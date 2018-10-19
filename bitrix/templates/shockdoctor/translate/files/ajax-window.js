var Wait = (function() {
    /**
     * Pre-loading of a image
     */
    Event.observe(window, 'load', function(){
        var img = new Image();
        var indicator = new Element('div', {'class': "popup-wait"}).update('<div></div>');
        img.src = indicator.down('div').getStyle('background-image').replace('url("', '').replace('")', '');
    });

    /**
     * Constructor
     */
    var Obj = function() {
        this.loadingFrame = 1;
        this.indicator = null;
        this.interval = null;
    };

    /**
     * @param wrapDiv wrapper for indicator
     * @return {*}
     */
    Obj.prototype = {
        show: function(wrapDiv) {
            if (!wrapDiv) {
                return;
            }

            this.indicator = new Element('div', { 'class': 'popup-wait'}).update('<div class="frame"><div class="img"></div></div>');
            wrapDiv.appendChild(this.indicator);

            var t = this;
            var animate = function() {
                t.indicator.down('.img').setStyle({'top': (t.loadingFrame * -24) + 'px'});
                t.loadingFrame = (t.loadingFrame + 1) % 12;
            };
            if (this.interval) {
                clearInterval(this.interval);
            }
            this.interval = setInterval(animate, 80);
            return this;
        },

        /**
         * Removing of a indicator
         * @return {*}
         */
        hide: function() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
            this.indicator.remove();
            return this;
        }
    };

    return Obj;
})();

/**
 * Static class for window wrapper
 * @return {Function}
 * @constructor
 */
var Wrapper = (function() {
    //protected
    var windows = new Array();
    var wrapper;
    var layer;

    var closeAll = function() {
        windows.each(function(element) {
            element.win.close();
        });
    };
    //constructor
    var Instance = function() {
        layer = new Element('div', { 'class': 'layer' });
        wrapper = new Element('div', { 'class': 'window-wrapper' });
        wrapper.insert(layer);

        //close on click by wrapper
        layer.observe('click', closeAll);
    };

    //public
    Instance.prototype = {
        /**
         *
         * @return {*}
         */
        show: function() {
            var height = Math.max(800, parseInt($$('body')[0].getHeight()), document.viewport.getHeight());
            $(layer).setStyle({height: height + 'px'});
            wrapper.show();
            return this;
        },
        /**
         *
         * @return {*}
         */
        hide: function() {
            wrapper.hide();
            return this;
        },
        /**
         *
         * @param {AjaxWindow} window
         * @return {*}
         */
        addWindow: function(window) {
            windows[windows.length] = window;
            $(window.win.getId()).wrap(wrapper);
            return this;
        }
    };

    return new Instance();
})();

var AjaxWindow = Class.create();

/**
 * AjaxWindow implementation
 * @type {Object}
 */
AjaxWindow.prototype = {
    win: null,
    visible: false,
    center: true,
    cachedForm: null,
    wait: null,
    params: {},
    /**
     * constructor
     *
     * @param params
     */
    initialize: function(params) {
        var defaultParams = {
            'url': '',
            title: '',
            contentElement: ''
        };
        this.params = Object.extend(defaultParams, params);
        this.wait = new Wait();
    },
    /**
     * initialization of a window
     *
     * @return {*}
     */
    initWindow: function() {
        if (this.win) {
            return this.win;
        }
        var title = this.params.title;
        var t = this;
        this.win = new Window({
            zIndex: 1001, width: 500, height: 350, className: "window", title: title, recenterAuto:false,
            showEffectOptions: {duration: 0.2},
            hideEffectOptions: {duration: 0.1},
            draggable: false,

            onClose: function() {
                Wrapper.hide();
                t.visible = false;
            },
            onShow : function() {
                t.visible = true;
            }
        });
        if (this.params.url) {
            this.wait.show(this.win.getContent());
            this.loadForm();
        } else {
            this.win.getContent().update(this.params.contentElement.innerHTML);
        }
        Wrapper.addWindow(this);
    },

    /**
     * Initialization of a form
     */
    initForm: function() {
        var t = this;
        var closeBtn;
        if (closeBtn = $(this.win.getId()).down('.wnd-close')) {
            closeBtn.observe('click', function() {
                t.win.close();
            });
        }

        var form = $(t.win.getId()).down('form');
        if (form) {
            var formId = form.readAttribute('id');
            var dataForm = new VarienForm(formId, true);
            Form.getElements(formId).each(function(element) {
                element.setAttribute('autocomplete', 'off');
            });
        }

        var submitBtn;
        if (submitBtn = $(this.win.getId()).down('.wnd-submit')) {
            submitBtn.observe('click', function() {
                if (!form) {
                    return;
                }

                /**
                 * this will be user for Create Account form    
                 */
                if (form.hasClassName('create-account')) {
                    //form.month.addClassName('validate-full-date');
                }
                if (dataForm.validator && !dataForm.validator.validate()){

                    if (form.hasClassName('create-account')) {
                        //form.month.removeClassName('validate-full-date');
                    }

                    return false;
                }

                t.wait.show(t.win.getContent());

                var url = form.readAttribute('action');

                new Ajax.Request(url, {
                    method: 'post',
                    parameters: form.serialize(true),
                    onSuccess: function(transport) {
                        var campaign = (form.id == 'login-form') ? 'Login' : 'Account Creation';
                        t.wait.hide();
                        t.displayLoadedForm(transport.responseJSON);
                        _gaq.push(['_trackEvent', campaign, 'Success']);
                    }
                });
            });
        }

        var openButtons = $(this.win.getId()).select('.wnd-open');
        openButtons.each(function(element) {
            Event.observe(element, 'click', function(event) {
                var windowName = element.getAttribute('wnd');
                // if (windowName != null) {
                //     Event.stop(event);
                // }
                if (windowsInstances[windowName]) {
                    t.win.hide();
                    windowsInstances[windowName].show();
                    if (windowName == 'registration') {
                        _gaq.push(['_trackEvent', 'Account Creation', 'Initiated']);
                    }
                }
            });
        });
        var waitButtons = $(this.win.getId()).select('.wnd-wait');
        waitButtons.each(function(element) {
            Event.observe(element, 'click', function() {
                t.wait.show(t.win.getContent());
            });
        });
    },
    /**
     * @param json
     */
    displayLoadedForm: function(json) {
        var t = this;
        var form;
        this.center = json.center ? true : false;
        if (form = json.form) {
            t.win.getContent().update(form);
            t.initForm();
            t.autoSizeWindow(json.width);
            if (json.redirect) {
                t.win.setCloseCallback(function() {
                    t.wait.show(t.win.getContent())
                    window.location = json.redirect;
                });
            } else if (json.reload) {
                t.win.setCloseCallback(function() {
                    t.wait.show(t.win.getContent())
                    window.location.reload();
                });
            }

            if (typeof json.title != 'undefined') {
                t.win.setTitle(json.title);
            }
        } else if (json.redirect) {
            t.wait.show(t.win.getContent())
            window.location = json.redirect;
        } else if (json.reload) {
            t.wait.show(t.win.getContent())
            window.location.reload();
        }
    },
    /**
     * Ajax loading
     */
    loadForm: function() {
        var t = this;

        if (this.cachedForm) {
            t.win.getContent().update(this.cachedForm);
        }

        new Ajax.Request(this.params.url, {
            method: 'post',
            onSuccess: function(transport) {
                t.displayLoadedForm(transport.responseJSON);
            }
        });

    },
    /**
     * Displaying of a window
     */
    show: function() {
        var b = this.win;
        this.initWindow();
        var errors = this.win.element.select('.validation-advice');
        if (errors.length) {
            for (var i in errors){
                if (errors.hasOwnProperty(i)) {
                    errors[i].remove();
                }
            }
        }
        if (errors = this.win.element.down('.errors')) {
            errors.remove();
        }
        var element = this.win.element.down('div.window_content');
        if (this.center) {
            this.win.showCenter(false);
        } else {
            this.win.showCenter(false, 40);
        }
        if (b || (this.win && this.wait.interval == null)) {
            element.setStyle({height: 'auto'});
        }
        Wrapper.show();
    },
    /**
     * Auto size for window and auto position
     * @param {int|null} width
     * @param {int|null} height
     */
    autoSizeWindow: function(width, height) {
        var t = this;
        var element = this.win.element.down('div.window_content');
        element.setStyle({height: 'auto'});
        if (!width) {
            width = element.getDimensions().width;
        } else {
            width = width - 15;
        }
        if (!height) {
            height = element.getDimensions().height
        }

        if (height < 350) {
            height = 350;
        }
        t.win.setSize(width, height);
        if (this.visible) {
            if (t.center) {
                t.win.showCenter(false);
            } else {
                t.win.showCenter(false, 40);
            }
        }
        element.setStyle({height: 'auto'});

        if (this.visible) {
            Wrapper.show();
        }
    }
};


// var windowsInstances = {};

// (function() {
//     var style = "font-size: 9pt; padding-left: -10px; font-family: 'Klavika Basic Medium'";
   
//     var registrationWindow = new AjaxWindow({
//         url: '/index.php/customer/account/create/',
//         title: 'CREATE AN ACCOUNT <em>*</em><span style="' + style + '">REQUIRED</span>'
//     });
//     windowsInstances.registration = registrationWindow;

//     Event.observe(window, 'load', function() {
//         $$('.registration_link').each(function(element) {
//             element.observe('click', function(event) {
//                 registrationWindow.show();
//                 // Track account creation init event
//                 _gaq.push(['_trackEvent', 'Account Creation', 'Initiated']);
//                 event.preventDefault();
//             });
//         });
//     });
// })();

// (function() {

//     var loginWindow = new AjaxWindow({
//         url: '/index.php/customer/account/login/'
//     });
//     windowsInstances.login = loginWindow;

//     Event.observe(window, 'load', function() {
//         $$('.login_link').each(function(element) {
//             element.observe('click', function(event) {
//                 loginWindow.show();
//                 event.preventDefault();
//             });
//         });
//     });
// })();

// (function() {

//     windowsInstances.loginCheckout = new AjaxWindow({
//         url: '/index.php/customer/account/login/?checkout=1'
//     });
// })();

// (function() {
 
//     windowsInstances.forgot = new AjaxWindow({
//         url: '/index.php/customer/account/forgotpassword/'
//     });
// })();