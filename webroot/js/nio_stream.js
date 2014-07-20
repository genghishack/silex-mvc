function StreamVisualizer(
	tiles, 
	tile_div,
	socket_room
) {

    var myTiles = [];

    init();

    function init() {
        for (var i=0; i<tiles.length; i++) {
            myTiles.push({
                time: 0,
                priority: 0,
                spec: tiles[i],
                id: 0,
                data: null
            });
        }

        jQuery('.tile').each(function() {
            addTileHandlers(jQuery(this));
        });

        connectToWebSocket(function(msg) {
            handleMessage(jQuery.parseJSON(msg));
        });
    }

    function handleMessage(msg) {
        var tileType = getValue(msg, 'type', 'no-type'),
            tilePriority = parseInt(getValue(msg, 'priority', '1')),
            tileFlag = getValue(msg, 'flag', 'old'),
            msgId = getValue(msg, 'id', 0),
            msgData = getValue(msg, 'id_value', 1);
            
        var tileToReplace = findAvailableTile(
        	tileType, tilePriority, tileFlag, msgId, msgData
    	);

        if (!tileToReplace) {
            // console.log("No available tile for " + msg);
            return;
        }

        // Define what swap function we want to use
        var swapFunc = swapTile;
        if (tileToReplace.id == msgId) {
            // we are updating a tile, not swapping in a new one
            swapFunc = updateTile;
        }

        // console.log("Replacing tile " + tileToReplace.spec.divId);
        tileToReplace.id = msgId;
        tileToReplace.data = msgData;
        tileToReplace.priority = tilePriority;
        tileToReplace.time = getCurrentTime();

        swapFunc(jQuery('#' + tileToReplace.spec.divId + ' .tile-container'), makeTile(
            tileType, // the type of tile to make
            tileToReplace.spec.rows, // how many rows it will take up
            tileToReplace.spec.cols, // how many cols it will take up
            msg // the rest of the data to use in making the tile
        ));
    }

    function findAvailableTile(type, priority, flag, id, data) {
        var availableTiles = [],
            currentScore = {
                afterMax: -1, //number of seconds after the max
                minMaxPct: 0.0 //percent of the way into the range
            };
        
        // console.log("Finding an available tile for " + type + " - " + priority);

        for (var i=0; i<myTiles.length; i++) {
            var tile = myTiles[i],
                tileDiv = jQuery('#' + tile.spec.divId),
                tileLocked = (tileDiv.hasClass("locked-click") || 
                                tileDiv.hasClass("locked-mouse") || 
                                tileDiv.hasClass("flipped")) ||
                                tileDiv.hasClass("tile-full");
            // console.log("Checking tile...");
            // console.log(tile);

            // Check if the tile already exists here
            if (tile.id == id) {
                if (tile.data == data || tileLocked) {
                    // It has the same ID and has the same data, we aren't going to replace ANY tile
                    // OR
                    // The tile is locked, but it is our best bet
                    return false;
                } else {
                    // It has the same ID but has new data, return this tile for updating
                    return tile;
                }
            }

            if (tileLocked) {
                // We know it's not our original tile (based on ID) and the tile is locked, move along
                continue;
            }

            // Check the priority matches the spec for this tile
            if ((! checkPriority(tile.spec.minPriority, priority, false)) ||
                (! checkPriority(tile.spec.maxPriority, priority, true))) {
                // console.log("Priority doesn't match");
                continue;
            }

            // Check if the tile type is not in the available types
            if (! typesContains(tile.spec.availableTypes, type, true)) {
                // console.log("Tile type not included");
                continue;
            }

            // Check if the tile type is in the excluded types
            if (typesContains(tile.spec.excludedTypes, type, false)) {
                // console.log("Tile type excluded");
                continue;
            }

            var tileDuration = getCurrentTime() - tile.time,
                priorityDurations = getDurationsFromPriority(tile.priority, flag),
                tileDurationAfterMin = tileDuration - priorityDurations[0],
                tileDurationAfterMax = tileDuration - priorityDurations[1],
                myDurationPct = tileDurationAfterMin / (tileDurationAfterMin - tileDurationAfterMax),
                setTile = function() {
                    availableTiles = [tile];
                    currentScore = {
                        afterMax: tileDurationAfterMax,
                        minMaxPct: myDurationPct
                    };
                };


            if (tileDurationAfterMin < 0) {
                // We haven't had the minimum time yet on this tile
                //console.log("Tile hasn't hit minimum");
                continue;
            }

            if (currentScore.afterMax > 0) {
                // The current one is after the max, we better be too then
                if (tileDurationAfterMax > currentScore.afterMax) {
                    // This tile is more after the max than the previous tile, so it's useable
                    setTile();
                } else if (tileDurationAfterMax == currentScore.afterMax) {
                    // we have an after max tie, join the party!
                    availableTiles.push(tile);
                } else {
                    // we are after max, but not as much so as the best option(s)
                }
                continue;
            }

            if (tileDurationAfterMax > 0) {
                // we are after the max and no one else is, use this tile
                setTile();
                continue;
            }

            // If we are here, that means we are after the min but before the max

            // Nothing available yet, I guess that's me!
            if (availableTiles.length == 0) {
                setTile();
                continue;
            }

            // Find out if we are more replaceable than the current one
            // by comparing how far into the range [minDuration, maxDuration] we are
            var myDurationPct = tileDurationAfterMin / (tileDurationAfterMin - tileDurationAfterMax),
                availableDurationPct = currentScore.minMaxPct;

            if (myDurationPct > availableDurationPct) {
                setTile();
            } else if (myDurationPct == availableDurationPct) {
                availableTiles.push(tile);
            }
        }

        if (availableTiles.length == 0) {
            // no available tiles? oh no!
            return false;
        } else {
            // return a random tile from the list of possibles
            return availableTiles[Math.floor(Math.random() * availableTiles.length)];
        }
    }

    function getValue(msg, key, defaultValue) {
        if (key in msg) {
            return msg[key];
        }
        return defaultValue;
    }

    function checkPriority(prioritySpec, myPriority, maxPriority) {
        /***
         * Check that myPriority meets the priority spec.
         * maxPriority is true if the prioritySpec represents the "max priority"
         */
        if (maxPriority) {
            return myPriority <= prioritySpec || prioritySpec <= 0;
        } else {
            return myPriority >= prioritySpec;
        }
    }

    function typesContains(types, type, return_on_empty) {
        /***
         * Returns whether or not type is contained in the types list
         * Specify return_on_empty with what to return if the list is empty
         */
        if (types.length == 0) {
            return return_on_empty == true;
        }
        return jQuery.inArray(type, types) >= 0;
    }

    function getCurrentTime() {
        if (Date.now)
            return Math.round(Date.now() / 1000);
        return Math.round(new Date().getTime() / 1000);
    }

    function connectToWebSocket(callback) {
        try {
            var host = '54.89.166.226:443',
                room = socket_room || 'default', 
                socket = io.connect('http://' + host);

            socket.on('connect', function(data) {
                //console.log("connected to room " + room);
                socket.emit('ready', room);
            });

            // Listen for the announce event.
            socket.on('recvData', function(data) {
                callback(data);
            });
        } catch(e) {
            console.error("Unable to connect to stream");
            console.error(e);
        }
    }

}

function swapTile(oldTile, newTile) {
    /***
     * This function takes an old tile and replaces it with newTile.
     * It can animate the action if it chooses to.
     */

    jQuery(oldTile).fadeOut("fast", function() {
        jQuery(oldTile).replaceWith(jQuery(newTile));
        jQuery(oldTile).fadeIn("fast", function() {
            addInnerTileHandlers(jQuery(newTile).closest('.tile'));
        });
    });
}

function updateTile(oldTile, newTile) {
    /***
     * This function will update a tile with a new one. It is different than swap
     * in that the tile type of each can be assumed to be the same. This function
     * will get called when a tile with the same ID needs to be updated with some
     * new data (i.e. for monitoring)
     */
    jQuery(oldTile).replaceWith(jQuery(newTile));
    addInnerTileHandlers(jQuery(newTile).closest('.tile'));
}

/**
 * Do things to the tile after it has been initialized
 */
function addTileHandlers(tile) {
    var tile = jQuery(tile);

    _addLockHandler(tile);
    _addTileClickHandler(tile);
}

/**
 * Do things to the tile after it has been swapped in
 */
function addInnerTileHandlers(tile) {
    var tile = jQuery(tile);

    _addPinClickHandler(tile);
    _addVideoPlayHandler(tile);
    _addInnerClickKillHandlers(tile);
}

function _addInnerClickKillHandlers(tile) {
    var killFunc = function(e) {
        e.stopPropagation();
    };

    tile.find('a').click(killFunc);
}

function _addLockHandler(tile) {
    tile.mouseenter(function(event) {
            tile.addClass("locked-mouse");
        })
        .mouseleave(function() {
            tile.removeClass("locked-mouse");
        })
        .bind('touchend', function() {
            tile.removeClass("locked-mouse");
        });
}

function _addPinClickHandler(tile) {
    tile.find('.pinned')
        .click(function(e) {
            tile.toggleClass("locked-click");
            e.preventDefault();
            e.stopPropagation();
        });
}

function _addTileClickHandler(tile) {
    tile.click(function(e) {
        tile.toggleClass('tile-full', 300, function() {
            if (tile.hasClass('tile-full')) {
                // we are expanding the tile
                tile.closest('.js-packery').data('packery').fit(tile.get(0));
            } else {
                // Redo packery layout
                tile.closest('.js-packery').data('packery').layout();
                e.stopPropagation();
            }
        });
    });
}

function _addVideoPlayHandler(tile) {
    tile.find('.play-button').click(function(e) {
        e.preventDefault();
        launchPlayer(tile.find('.youtube-player'));
        tile.find('.video-cover-image').hide();
    });
}

function isMobileBrowser() {
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
    return check; 
}

function launchPlayer(playerDiv) {
    var videoId = playerDiv.attr('id');

    player = new YT.Player(videoId, {
        height: '100%',
        width: '100%',
        videoId: videoId,
        events: {
            'onReady': function(e) {
                if (! isMobileBrowser()) {
                    e.target.playVideo();
                }
            }
        }
    });
}

function getDurationsFromPriority(priority, flag) {
    /***
     * Return an array tuple of the minDuration and maxDuration for the given priority
     *
     * A flag (old, new, vip) can also be passed to adjust the minimums
     */
    if (priority in durations) {
        var theMin = durations[priority]['min'],
            theMax = durations[priority]['max'];

        if (flag == 'new') {
            theMin = durations[priority]['minn'];
        } else if (flag == 'vip') {
            theMin = 0;
        }

        return [theMin, theMax];
    }

    return [0,0];
}

jQuery(function() {
    vizz = new StreamVisualizer(
    	streamTileSpecs, 
    	jQuery('#' + streamDivId),
    	socketRoom
	);
});
