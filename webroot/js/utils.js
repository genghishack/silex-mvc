NIO.utils.extendGlobal('NIO.utils', {

	exception: function(message) {
        if (window.console) {
        	console.log(message);
        };
	},

    getCurrentPath: function() {
        return window.location.pathname;
    },

	navigate: function(uri){
		if ( (uri.charAt(0)==='/' || uri.charAt(0)==='#') && uri.length > 1) {uri = uri.substring(1);}
		if (location.hash.substring(1) === uri || location.pathname.substring(1) === uri){
			Backbone.history.loadUrl();
		} else {
			Backbone.history.navigate(uri, {trigger:true});
		}
	},

    getParameterByName: function(name) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    },

    useStaticData: function() {
        var testData = NIO.utils.getParameterByName('testdata');
        if ('on' === testData && ('local' === App.constants.environment || 'dev' === App.constants.environment)) {
            return true;
        }
        return false;
    },

    validateEmail: function(email) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return reg.test(email);
    },

    htmlDecode: function(input) {
        var e = document.createElement('div');
        e.innerHTML = input;
        return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
    },


    /* ISD Code inputs and events */

    populateISDOptions: function(selector) {
        var el = $(selector);
        var html = [];
        _.each(App.ISDCodes, function(item, index) {
            html.push('<option value="' + item.value + '">' + item.value + ' - ' + item.label + '</option>');
        });
        el.append(html.join('\n'));
    },

    initializeISDInputs: function($container) {
        // Initialize the state of the ISD inputs within a container element.
        // If the ISD value is blank or is one of the available options,
        // show the select box with the option selected, instead of the text box.
        $('input.country-code').mask(App.settings.ISDMask);
        $('select.country-code', $container).each(function(i,el) {
            var ISDCode = $(el).siblings('input.country-code').val();
//            console.log($(el), $(el).siblings(), $(el).siblings('input.country-code'));
//            console.log('ISDCode: ', ISDCode);
            while(ISDCode.length < 3) {
                ISDCode = '0' + ISDCode;
            }
            if (!ISDCode || App.utils.findValueInOptionList(App.ISDCodes, ISDCode)) {
//                if (!ISDCode || ISDCode === '000') {
//                    $(el).val('001').hide();
//                    $(el).siblings('input.country-code').show();
//                    $(el).siblings('input.phone').mask(App.settings.intlPhoneMask);
//                } else if (ISDCode === '001') {
                if (!ISDCode || ISDCode === '000' || ISDCode === '001') {
                    $(el).val('001');
                    $(el).siblings('input.phone').mask(App.settings.usPhoneMask);
                    $(el).show();
                    $(el).siblings('input.country-code').hide();
                } else {
                    $(el).val(ISDCode);
                    $(el).siblings('input.phone').mask(App.settings.intlPhoneMask);
                    $(el).show();
                    $(el).siblings('input.country-code').hide();
                }
            } else {
                $(el).val('001').hide();
                $(el).siblings('input.country-code').show();
                $(el).siblings('input.phone').mask(App.settings.intlPhoneMask);
            }
        });

        $container.on('change', 'select.country-code', App.utils.handleISDSelectorChange);
        $container.on('blur', 'input.country-code', App.utils.blurISDInput);
    },

    handleISDSelectorChange: function(ev) {
        var el = $(ev.currentTarget);
        if (el.val() === '000') {
            el.val('').hide();
            el.siblings('input.country-code').val('').show().focus();
            el.siblings('input.phone').mask(App.settings.intlPhoneMask);
        } else {
            if (el.val() === '001') {
                el.siblings('input.phone').mask(App.settings.usPhoneMask);
            } else {
                el.siblings('input.phone').mask(App.settings.intlPhoneMask);
            }
            el.siblings('input.country-code').val(el.val());
        }
    },

    blurISDInput: function(ev) {
        var el = $(ev.currentTarget);
        var value = parseInt(el.val()).toString();
        while (value.length < 3) {
            value = '0' + value;
        }
        if (value === 'NaN' || value === '000' || value === '001') {
            el.val('001').hide();
            el.siblings('select.country-code').val('001').show();
            el.siblings('input.phone').mask(App.settings.usPhoneMask);
        } else if (App.utils.findValueInOptionList(App.ISDCodes, value)) {
            el.siblings('select.country-code').val(value).show();
            el.hide();
        } else {
            el.val(value);
            el.siblings('input.phone').mask(App.settings.intlPhoneMask);
        }
    },


    /* Country/State inputs and interactions */

    initializeCountryStateInputs: function($container) {
        $('.stateTxt', $container).attr('maxlength', 25);
        $('.stateTxt', $container).css('width', '26px').css('text-transform', 'uppercase');
        $('.postalCode', $container).attr('maxlength', 10);
        if (_.indexOf(['US', ''], $('.countrySelect', $container).val()) !== -1) {
            $('.stateTxt', $container).val('').hide();
            $('.stateSelect', $container).show();
            $('.postalCode', $container).mask(App.settings.usPostalCodeMask);
        } else if ('CA' === $('.countrySelect', $container).val()) {
            $('.stateTxt', $container).mask(App.settings.usStateMask);
            $('.stateTxt', $container).show();
            $('.stateSelect', $container).val('').hide();
            $('.postalCode', $container).unmask();
        } else {
            $('.stateTxt', $container).unmask();
            $('.stateTxt', $container).css('width', '229px').css('text-transform', 'none');
            $('.stateTxt', $container).show();
            $('.stateSelect', $container).val('').hide();
            $('.postalCode', $container).unmask();
        }

        $container.on('change', '.countrySelect', App.utils.resetCountryStateInputs);
    },

    resetCountryStateInputs: function(ev) {
        var $container = $(ev.currentTarget).parents('section').first();
        $('.stateTxt', $container).mask(App.settings.usStateMask);
        $('.stateTxt', $container).css('width', '26px').css('text-transform', 'uppercase');
        if (_.indexOf(['US', ''], $('.countrySelect', $container).val()) !== -1) {
            $('.stateTxt', $container).val('').hide();
            $('.stateSelect', $container).val('').show();
            $('.postalCode', $container).mask(App.settings.usPostalCodeMask);
        } else if ('CA' === $('.countrySelect', $container).val()) {
            $('.stateTxt', $container).val('').show();
            $('.stateSelect', $container).val('').hide();
            $('.postalCode', $container).unmask();
        } else {
            $('.stateTxt', $container).unmask();
            $('.stateTxt', $container).css('width', '229px').css('text-transform', 'none');
            $('.stateTxt', $container).val('').show();
            $('.stateSelect', $container).val('').hide();
            $('.postalCode', $container).unmask();
        }
    },

    /**
     * Return a clone of the USStates array.  
     * This is so that the resulting array may be modified without affecting the original.
     * @returns {Array}
     */
    getUSStates: function() {
        var returnArr = [];
        _.each(App.constants.USStates, function(item, index) {
            returnArr.push(_.clone(item));
        });
        return returnArr;
    },

    /**
     * See above comment
     * @returns {Array}
     */
    getCAProvinces: function() {
        var returnArr = [];
        _.each(App.constants.CAProvinces, function(item, index) {
            returnArr.push(_.clone(item));
        });
        return returnArr;
    },

    /**
     * See above comment
     * @returns {Array}
     */
    getCountries: function() {
        var returnArr = [];
        _.each(App.constants.countries, function(item, index) {
            returnArr.push(_.clone(item));
        });
        return returnArr;
    },

    /**
     * See above comment
     * @returns {Array}
     */
    getISDCodes: function() {
        var returnArr = [];
        _.each(App.constants.ISDCodes, function(item, index) {
            returnArr.push(_.clone(item));
        });
        return returnArr;
    },

    // Note: could be prototyped onto Backbone.View?
    render: function(ctx) {
        ctx.$el.html(Mustache.render(
            ctx.template,
            ctx.viewData,
            ctx.partials
        ));
    }

});