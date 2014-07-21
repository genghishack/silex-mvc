NIO.utils.extendGlobal('NIO.settings', {

    ISDMask: '9?99',
    usPhoneMask: '(999) 999-9999',
    intlPhoneMask: 'iiiiiiiiii?iiiiiiiiii',
    usPostalCodeMask: '99999?-9999',
    usStateMask: 'aa',
    passwordRegex: '(?=(?:.*?[A-Za-z]){1})(?=(?:.*?[0-9]){1})\\S{6,20}',

    dateRangeOptions: [
        {index: 0, description: 'Last day'},
        {index: 1, description: 'Last 3 days'},
        {index: 2, description: 'Last 7 days'},
        {index: 3, description: 'Last 30 days'},
        {index: 4, description: 'Last 60 days', selected: true},
        {index: 5, description: 'Custom Date'}
    ],

    paginationPageSizeOptions: {
        5: 5,
        10: 10,
        15: 15,
        25: 25,
        50: 50,
        100: 100,
        All: -1
    }

});