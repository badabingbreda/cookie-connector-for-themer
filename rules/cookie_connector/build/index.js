var addRuleTypeCategory = BBLogic.api.addRuleTypeCategory,
    addRuleType = BBLogic.api.addRuleType,
    getFormPreset = BBLogic.api.getFormPreset;

addRuleTypeCategory( 'cookieconnector', {
    label: cookie_js_translations.__.cookie_connector
});


addRuleType('cookieconnector/cookie', {
    label: cookie_js_translations.__.cookie_value,
    category: 'cookieconnector',
	form: function form(_ref) {
		var rule = _ref.rule;
		var operator = rule.operator;

		return {
			key: {
				type: 'text',
				placeholder: cookie_js_translations.__.cookie_name,
				visible: true,
			},
			operator: {
				type: 'operator',
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with', 'contains', 'does_not_contain', 'is_less_than' , 'is_less_than_or_equal_to' , 'is_greater_than' , 'is_greater_than_or_equal_to' , 'is_set', 'is_not_set' ],
				visible: true,
			},
            compare: {
                type: 'text',
                placeholder: cookie_js_translations.__.cookie_value,
				visible: ( operator == 'is_set' || operator == 'is_not_set' ) ? false : true,
            },
			expiredval: {
				type: 'text',
				placeholder: cookie_js_translations.__.expired_return_value,
				visible: true,
			},

		};
	}
});
