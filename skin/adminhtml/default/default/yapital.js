YapitalConfig = Class.create();
YapitalConfig.prototype = {

    initialize: function (config) {
        this.config = config;
        this.changed = false;

        var that = this;
        document.observe("dom:loaded", function () {
            that.listenOnChanges();
        });
    },

    listenOnChanges: function () {
        var that = this;

        $$('#payment_yapital_standard input').forEach(function (input) {
            input.observe('change', function () {
                if (!that.changed) {
                    that.changed = true;
                    window.onbeforeunload = that.unloadNotice;
                }
            })
        });


        $$('.content-header td.form-buttons button').forEach(function (input) {

            input.stopObserving('click');
            input.removeAttribute("onclick");

            input.setAttribute('onclick', 'window.onbeforeunload = null; configForm.submit();');
        });

    },

    unloadNotice: function (e) {
        var message = 'Are you sure you want to leave?';
        var e = e || window.event;
        if (e) { // IE, FF<4
            e.returnValue = message;
        }
        // Safari, FF, Chrome
        return message;
    },

    validate: function () {

        params = {
            shop_id: 1,
            client_id: $('payment_yapital_' + this.config.config_path + '_client_id').value,
            secret_key: $('payment_yapital_' + this.config.config_path + '_secret_key').value
        };

        $(this.config.config_path + '_validation_message_span').addClassName('no-display');
        $(this.config.config_path + '_validation_span').removeClassName('no-display');

        var that = this;
        new Ajax.Request(this.config.validate_url, {
            parameters: params,
            loaderArea: false,
            asynchronous: false,
            onSuccess: function (transport) {
                var response;

                response = eval('(' + transport.responseText + ')');
                if (false == response.has_errors) {
                    // no errors: it works!
                    that.disableValidateButton();
                } else {
                    // TODO ERROR
                }

                $(that.config.config_path + '_validation_span').addClassName('no-display');
                $(that.config.config_path + '_validation_message_span').removeClassName('no-display');
                $(that.config.config_path + '_validation_message_span').update(response.message);
            },

            onFailure: function (transport) {
                $(that.config.config_path + 'validation_span').addClassName('no-display');
                $(that.config.config_path + 'validation_message_span').removeClassName('no-display');
                $(that.config.config_path + 'validation_message_span').update('Internal error during validation.'); // TODO: Multilanguage!
            }

        });
        this.enableValidateButton();
    },


    enableValidateButton: function () {
        Form.Element.enable(this.config.config_path + '_validate_button');
        $(this.config.config_path + '_validate_button').removeClassName('disabled');
    },

    disableValidateButton: function () {
        Form.Element.disable(this.config.config_path + '_validate_button');
        $(this.config.config_path + '_validate_button').addClassName('disabled');
    },

    generateNotificationSecret: function () {
        var uniq = Math.floor(Math.random() * 0xF + 10).toString(36);
        uniq += Math.floor(Math.random() * 0x100000000).toString(36);
        uniq += Math.floor(Math.random() * 0x1000).toString(36);
        uniq += Math.floor(Math.random() * 0x1000).toString(36);
        uniq += Math.floor(Math.random() * 0x1000).toString(36);

        $$('#payment_yapital_' + this.config.config_path + '_notification_secret')[0].value = uniq;
    },

    register: function (registerUrl) {

        console.log('#payment_yapital_' + this.config.config_path + '_notification_secret is not long enough.');
        if ($$('#payment_yapital_' + this.config.config_path + '_notification_secret')[0].value.length < 3) {
            this.generateNotificationSecret();
        }

        params = {
            store_id: 1,
            notification_secret: $('payment_yapital_' + this.config.config_path + '_notification_secret').value,
            notification_id: $('payment_yapital_' + this.config.config_path + '_notification_id').value
        };

        $(this.config.config_path + '_notification_message_span').addClassName('no-display');
        $(this.config.config_path + '_notification_span').removeClassName('no-display');

        var that = this;
        new Ajax.Request(registerUrl, {
            parameters: params,
            loaderArea: false,
            asynchronous: false,
            onSuccess: function (transport) {
                var response;

                response = eval('(' + transport.responseText + ')');
                console.log(response);
                if (false == response.has_errors) {
                    // no errors: it works!
                    that.disableValidateButton();
                } else {
                    // TODO ERROR
                }

                $(that.config.config_path + '_notification_span').addClassName('no-display');
                $(that.config.config_path + '_notification_message_span').removeClassName('no-display');
                $(that.config.config_path + '_notification_message_span').update(response.message);
            },

            onFailure: function (transport) {
                $(that.config.config_path + '_notification_span').addClassName('no-display');
                $(that.config.config_path + '_notification_message_span').removeClassName('no-display');
                $(that.config.config_path + '_notification_message_span').update('Internal error during validation.'); // TODO: Multilanguage!
            }

        });

        this.enableValidateButton();
    },


    unregister: function (unregisterUrl) {
        // TODO: Multilanguage
        if (confirm('This will delete all notifications when a customer has paid. Your shop will no longer receive any note if the order has been paid except you register a new notification.')) {
            params = {
                store_id: 1,
                notification_secret: $('payment_yapital_' + this.config.config_path + '_notification_secret').value,
                notification_id: $('payment_yapital_' + this.config.config_path + '_notification_id').value
            };

            $(this.config.config_path + '_notification_message_span').addClassName('no-display');
            $(this.config.config_path + '_notification_span').removeClassName('no-display');

            var that = this;
            new Ajax.Request(unregisterUrl, {
                parameters: params,
                loaderArea: false,
                asynchronous: false,
                onSuccess: function (transport) {
                    var response;

                    response = eval('(' + transport.responseText + ')');
                    console.log(response);
                    if (false == response.has_errors) {
                        // no errors: it works!
                    } else {
                        // TODO ERROR
                    }

                    $(that.config.config_path + '_notification_span').addClassName('no-display');
                    $(that.config.config_path + '_notification_message_span').removeClassName('no-display');
                    $(that.config.config_path + '_notification_message_span').update(response.message);
                },

                onFailure: function (transport) {
                    $(that.config.config_path + '_notification_span').addClassName('no-display');
                    $(that.config.config_path + '_notification_message_span').removeClassName('no-display');
                    $(that.config.config_path + '_notification_message_span').update('Internal error during validation.'); // TODO: Multilanguage!
                }

            });
        }
    },

    updateTransactions: function () {
        $(this.config.config_path + '_update_message_span').addClassName('no-display');
        $(this.config.config_path + '_update_span').removeClassName('no-display');

        var that = this;
        new Ajax.Request(this.config.update_url, {
            method: 'get',
            onSuccess: function (transport) {
                var response;
                response = eval('(' + transport.responseText + ')');

                $(that.config.config_path + '_update_span').addClassName('no-display');
                $(that.config.config_path + '_update_message_span').removeClassName('no-display');
                $(that.config.config_path + '_update_message_span').update(response.message);
            },

            onFailure: function (response) {
                $(that.config.config_path + '_update_span').addClassName('no-display');
                $(that.config.config_path + '_update_message_span').removeClassName('no-display');
                $(that.config.config_path + '_update_message_span').update('Internal error during validation.'); // TODO: Multilanguage!
            }
        });
    }

}
