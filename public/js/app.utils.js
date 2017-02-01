/**
 * jQuery Extensions
 * @param {object} $
 * @returns {mixed}
 */
(function ($) {
  var GEXT = {
    clearForm: function () {
      return this.each(function () {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        if (tag === 'form') {
          return $(':input', this)
            .clearForm();
        }
        if (type === 'text' || type === 'password' || tag === 'textarea') {
          this.value = '';
        } else if (type === 'checkbox' || type === 'radio') {
          this.checked = false;
        } else if (tag === 'select') {
          this.selectedIndex = -1;
        }
      });
    },
    getPath: function () {
      var paths = [];

      this.each(function (index, element) {
        var path;
        var $node = $(element);

        while ($node.length) {
          var realNode = $node.get(0);
          var name = realNode.localName;
          if (!name) {
            break;
          }

          name = name.toLowerCase();
          var parent = $node.parent();
          var sameTagSiblings = parent.children(name);

          if (sameTagSiblings.length > 1) {
            var allSiblings = parent.children();
            var i = allSiblings.index(realNode) + 1;
            if (i > 0) {
              name += ':nth-child(' + i + ')';
            }
          }

          path = name + (path ? ' > ' + path : '');
          $node = parent;
        }

        paths.push(path);
      });

      return paths.join(',');
    },
    scrollSpyX: function (a, b, c) {
      var jQuery = $;
      var f;
      var s = $(this);
      if (arguments.length === 0) {
        s.scrollSpy();
      }
      if (arguments.length === 1 && (typeof a === 'string' || a instanceof jQuery)) {
        s = a = typeof a === 'string' ? $(a) : a;
        $.scrollSpy(a);
      } else if (arguments.length === 1 && typeof a === 'function') {
        f = a;
        s.scrollSpy();
      } else if (arguments.length === 2 && (typeof a === 'string' || a instanceof jQuery) && typeof b === 'object') {
        s = a = typeof a === 'string' ? $(a) : a;
        $.scrollSpy(a, b);
      } else if (arguments.length === 2 && (typeof a === 'string' || a instanceof jQuery) && typeof b === 'function') {
        f = b;
        s = a = typeof a === 'string' ? $(a) : a;
        $.scrollSpy(a);
      } else if (arguments.length === 2 && typeof a === 'object' && typeof b === 'function') {
        f = b;
        s.scrollSpy(a);
      } else if (arguments.length === 3 && (typeof a === 'string' || a instanceof jQuery) && typeof b === 'object' && typeof c === 'function') {
        f = c;
        s = a = typeof a === 'string' ? $(a) : a;
        $.scrollSpy(a, b);
      } else {
        console.error('Invalid argument set');
      }

      window.ScrollSpyX = {};
      var visible = [];
      if (typeof f !== 'undefined') {
        s.on('scrollSpy:enter', function () {
          visible = $.grep(visible, function (value) {
            return value.is(':visible');
          });
          visible = visible.sort(function (a, b) {
            return b.offset().top - a.offset().top;
          });

          var $this = $(this);
          if (visible[0]) {
            if ($this.data('scrollSpy:id') < visible[0].data('scrollSpy:id')) {
              visible.unshift($(this));
            } else {
              visible.push($(this));
            }
          } else {
            visible.push($(this));
          }

          window.ScrollSpyX.visible = visible;
          f(visible[0], 'enter');
        });
        s.on('scrollSpy:exit', function () {
          visible = $.grep(visible, function (value) {
            return value.is(':visible');
          });
          visible = visible.sort(function (a, b) {
            return b.offset().top - a.offset().top;
          });

          if (visible[0]) {
            var $this = $(this);
            visible = $.grep(visible, function (value) {
              return value.attr('id') !== $this.attr('id');
            });
            visible = visible.sort(function (a, b) {
              return b.offset().top - a.offset().top;
            });
            if (visible[0]) { // Check if empty
              f(visible[0], 'exit');
            }
          }
        });
      }
    }
  };

  var BEXT = {
    isNumber: function (n) {
      return !isNaN(n);
    },
    isInt: function (n) {
      return $.isNumber(n) && n % 1 === 0;
    },
    isFloat: function (n) {
      return $.isNumber(n) && n % 1 !== 0;
    },
    isOdd: function (n) {
      return n % 2 !== 0;
    },
    isEven: function (n) {
      return n % 2 === 0;
    },
    isInArray: function (value, array) {
      return (array.indexOf(value) > -1);
    },
    isJsonString: function (str) {
      try {
        $.parseJSON(str);
        return true;
      } catch (e) {
        return false;
      }
    },
    safeParseJSON: function (str) {
      var $object;
      if (typeof str === 'string') {
        try {
          $object = $.parseJSON(str);
          return $object;
        } catch (e) {
          return null;
        }
      } else if (typeof str === 'object') {
        return str;
      }
    },
    jsonDecode: function (jsonString) {
      return $.safeParseJSON(jsonString);
    },
    isInPageAnchor: function (baseUrl, link) {
      return (new RegExp(baseUrl)).test(link) && (new RegExp('#')).test(link);
    },

    getAnchor: function (link) {
      var urlParts = link.toString().split('#');
      return urlParts[1];
    },
    getUrlBase: function (link) {
      link = link.split('?')[0];
      var a = link.split('/');
      a = a.splice(0, a.length - 1);
      return a.join('/');
    },
    scrollTo: function (name, semaphore, duration) {
      var $this = this;
      $this.scroll = function (animateOptions) {
        if (target.length) {
          var defaults = {
            duration: duration,
            queue: true,
            easing: 'easeOutCubic'
          };
          if (typeof animateOptions === 'object') {
            defaults = $.extend({}, defaults, animateOptions);
          }

          $('html, body').animate({
            scrollTop: target.offset().top
          }, defaults);
        }
      };

      var target = $('#' + name);
      target = target.length ? target : $('[name=' + name + ']');
      duration = typeof duration === 'undefined' ? 400 : duration;
      if (semaphore instanceof Semaphore) {
        semaphore.lock('func.scrollTo');
        $this.scroll({
          complete: function () {
            window.location.href = '#' + name;
            semaphore.unlock('func.scrollTo');
          }
        });
      } else {
        $this.scroll();
      }
    },
    range: function (min, max) {
      if (arguments.length === 1) {
        max = min;
        min = 0;
      }

      var a = [];
      for (var i = min; i < max + 1; i++) {
        a.push(i);
      }
      return a;
    },
    getKeys: function (obj) {
      var keys = [];
      for (var key in obj) {
        keys.push(key);
      }
      return keys;
    },
    uniqueArray: function (a) {
      var seen = {};
      var out = [];
      var len = a.length;
      var j = 0;
      for (var i = 0; i < len; i++) {
        var item = a[i];
        if (seen[item] !== 1) {
          seen[item] = 1;
          out[j++] = item;
        }
      }
      return out;
    }
  };

  var FNEXT = {
    /**
     * Input field autofill
     * @param {function} callable Expects parameters id, text, img, extra<br/>
     * id: ID of clicked item.<br/>
     * text: Display text of clicked item<br/>
     * img: Display image of clicked item<br/>
     * extra: An object containing extra data passed<br/>
     *
     * @param {string} scope Scope to search
     * @param {boolean} allowEnterKey Allow enter key to submit
     * @returns {object}
     */
    autoComplete: function (callable, scope, allowEnterKey) {
      window.is_timer = undefined;
      if (typeof allowEnterKey === 'undefined') {
        allowEnterKey = false;
      }
      if ($(this).is('input')) {
        //  No browser autocomplete, we have it covered
        $(this).attr('autocomplete', 'off');

        if (!allowEnterKey) { //Prevent enter key submit
          $(this).bind('keypress keydown keyup', function (e) {
            if (e.keyCode === 13) {
              e.preventDefault();
              return false;
            }
          });
        }

        //  Check key pressed
        $(this).on('keyup', function (e) {
          if (e.keyCode === 13 || e.keyCode === 27) {
            //  Enter or esc key pressed
            var select = $('div#is-poplist');
            if (select.length) {
              select.hide();
            }
            return false;
          } else {
            if (!isNaN(window.is_timer)) {
              clearTimeout(window.is_timer);
            }
            var input = $(this).val();
            if (input !== '') {
              //  Save input element scope
              var element = this;
              window.is_timer = setTimeout(function () {
                var url = window.HomeUrl + '/autocomplete';

                ajaxCall({
                  url: url,
                  data: {'terms': input, 'scope': scope},
                  onSuccess: function (data) {
                    var select = $('div#is-poplist');
                    //  Create popup if not exist
                    if (!select.length) {
                      select = $('body').append('<div id="is-poplist"></div>').find('div#is-poplist');
                    }
                    //  Position popup
                    var window_width = $(window).width();
                    var pop_width = $(select).width();
                    if (window_width > pop_width) {
                      var left = $(element).offset().left;
                      var area = left + pop_width;
                      //Place at the begining of input element
                      //If offscreen, allow default (right = 0)
                      select.css('left', area < window_width ? left : 'inherit');
                    }
                    //Push below input element
                    var top = $(element).offset().top + $(element).height();
                    select.css('top', top);

                    //  Populate
                    var items = '';
                    for (var key in data) {
                      if (data.hasOwnProperty(key)) {
                        items += '<span class="pop-item" extra="'
                          + JSON.stringify(data[key]['extra'])
                          + '" val="' + key + '">';
                        if (typeof (data[key]['image']) === 'string'
                          && data[key]['image'] !== '') {
                          items += '<img src="' + data[key]['image'] + '"/>';
                        }
                        items += data[key]['text'];
                        items += '</span>';
                      }
                    }
                    select.html(items);
                    $(select.children()).on('click', function () {
                      if (typeof callable === 'function') {
                        callable($(this).attr('val'), $(this).text(), $('img', this).attr('src'), JSON.parse($(this).attr('extra')));
                      }
                      select.hide();
                    });

                    $('body').on('click', function () {
                      select.hide();
                    });

                    select.show();
                  }
                });
              }, 500);
            } else {
              $('div#is-poplist').hide();
            }
          }
        });
      }
      return this;
    }
  };

  $.extend(BEXT);
  $.extend(GEXT);
  $.fn.extend(GEXT);
  $.fn.extend(FNEXT);
}(jQuery));

function notify(pane, response, style) {
  var handle = pane.prop('data-timer');
  if ($.isInt(handle)) {
    clearTimeout(handle);
  }

  //Remove *-text classes
  pane.removeClass(function (index, css) {
    return (css.match(/(^|\s)\w+-text/g) || []).join(' ');
  });
  if (typeof (response['message']) !== 'undefined') {
    pane.html(response['message']);
    pane.addClass((typeof (response['mode']) !== 'undefined') ?
      'text' + response.mode :
      (response['status'] === true ? 'text-success bg-success' : 'text-danger bg-danger'));
  } else {
    pane.html(toString(response));
    pane.addClass((typeof style === 'undefined') ? 'text-warning bg-warning' : style);
  }
  pane.show();
  pane.prop('data-timer', setTimeout(function () {
    pane.hide();
  }, 15000));
}

function Semaphore() {
  var $this = this;
  $this.locked = false;
  $this.lockKey = undefined;

  $this.lock = function (key) {
    if (typeof $this.lockKey === 'undefined' && !$this.locked) {
      $this.locked = true;
      $this.lockKey = key;
    }
  };

  $this.unlock = function (key) {
    if ($this.lockKey === key) {
      $this.locked = false;
      $this.lockKey = undefined;
    }
  };
}

/**
 * Value or default
 * @param {type} value
 * @param {type} defaultValue
 * @returns {unresolved}
 */
function vd(value, defaultValue) {
  return typeof (value) !== 'undefined' ? value : defaultValue;
}

function handleHttpErrors(xhr, form, element, notifyInForm) {
  if (vd(notifyInForm, true)) {
    element = $(vd(element, '.notify'), form);
  }
  if (xhr.status === 422) {
    if (typeof (xhr.responseJSON) !== 'object') {
      notify(element, {'status': false, 'message': xhr.responseJSON});
    } else {
      handle422ErrorObject(form, xhr.responseJSON, element);
    }
  } else if (xhr.status >= 400 && xhr.status < 500) {
    notify(element, {'status': false, 'message': xhr.responseText});
  } else if (xhr.status >= 500 && xhr.status < 600) {
    notify(element, {'status': false, 'message': 'Something snapped, please try again shortly.'});
  } else {
    //Fallback
    notify(element, xhr);
  }
}

function handle422ErrorObject(form, response, element) {
  var field_names = [];
  form.find(':input').each(function (i, o) {
    var name = $(o).attr('name');
    if (typeof name !== 'undefined') {
      field_names.push(name);
    }
  });
  var textArr = [];
  for (var field in response) {
    if (field in response) {
      textArr.push($(response).prop(field).join("<br/>"));
    }
  }
  var notification = {
    'message': textArr.join('<br/>'),
    'status': false
  };
  notify(element, notification);
}

(function ($) {
  /**
   * Initialize follow element
   * @param {function} stateChanged
   * @returns {$.fn}
   */
  $.fn.follow = function (stateChanged) {
    var fs = $(this).attr('fs');
    var e = $(this).attr('e');
    if (typeof (e) === 'undefined') {
      return this;
    }
    if (typeof (fs) === 'undefined') {
      fs = '0';
      $(this).attr('fs', fs);
    }

    $(this).on('click', function (e) {
      e.preventDefault();
      var elm = this;
      var state = $(elm).attr('fs');
      var entry_id = $(elm).attr('e');
      var type = $(elm).attr('t');
      $(elm).attr('disabled', 'true');
      ajaxCall({
        url: followroute,
        data: {
          id: entry_id,
          action: (state === '0' ? 'follow' : 'unfollow'),
          type: type
        },
        onSuccess: function (newState) {
          $(elm).attr('fs', newState);
          stateChanged(newState, elm);
        },
        onComplete: function () {
          $(elm).removeAttr('disabled');
        }
      });
    });
    return this;
  };

  /**
   * Initialize addtolibrary action element
   * @param {callable} stateChanged
   * @returns {$.fn}
   */
  $.fn.addToLibrary = function (stateChanged) {
    var ls = $(this).attr('ls');
    var e = $(this).attr('e');
    if (typeof (e) === 'undefined') {
      return this;
    }
    if (typeof (ls) === 'undefined') {
      ls = '0';
      $(this).attr('ls', ls);
    }

    $(this).on('click', function (e) {
      e.preventDefault();
      var elm = this;
      var state = $(elm).attr('ls');
      var entry_id = $(elm).attr('e');
      $(elm).attr('disabled', 'true');
      ajaxCall({
        url: addlibraryroute,
        data: {id: entry_id, action: (state === '0' ? 'add' : 'remove')},
        onSuccess: function (newState) {
          $(elm).attr('ls', newState);
          stateChanged(newState, elm);
        },
        onComplete: function () {
          $(elm).removeAttr('disabled');
        }
      });
    });
    return this;
  };

  /**
   * Search data from a url or an array
   * @param {mixed} datasource Url or array
   * @param {callable} callable function to call after search
   * @param {array} fields Fields to search
   * @param {boolean} cache set true to cache data if url is provided as datasource, else false
   * @param {boolean} allowEnterKey set true to enable Enter key for submitting
   * @returns {array} Items marching search terms
   */
  $.fn.instantSearch = function (datasource, callable, fields, cache, allowEnterKey) {
    var timer;
    var cache_data;
    var last_term;
    if (typeof fields === 'undefined') {
      fields = ['title'];
    }
    if (typeof cache === 'undefined') {
      cache = true;
    }
    if (typeof allowEnterKey === 'undefined') {
      allowEnterKey = false;
    }

    if ($(this).is("input")) {
      if (!allowEnterKey) { //Prevent enter key submit
        $(this).bind('keypress keydown keyup', function (e) {
          if (e.keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });
      }
      //Check key pressed
      $(this).on('keyup', function (e) {
        if (!isNaN(timer)) {
          clearTimeout(timer);
        }
        var input = $(this).val();
        if (input === '') {
          //Fetch all
          if (typeof (datasource) === 'object') {
            callable(datasource);
          } else {
            if (cache) {
              callable(cache_data);
            } else {
              ajaxCall({
                url: datasource, onSuccess: function (data) {
                  callable(data);
                }
              });
            }
          }
        } else if (input !== last_term) {
          last_term = input;
          timer = setTimeout(function () {
            if (typeof (datasource) === 'object') {
              //Search in provided data
              callable(searchArray(datasource, input, fields));
            } else {
              if (!cache) {
                ajaxCall({
                  url: datasource, data: {'q': input}, onSuccess: function (data) {
                    callable(data);
                  }
                });
              } else if (cache_data === undefined) {
                ajaxCall({
                  url: datasource, onSuccess: function (data) {
                    callable(searchArray(cache_data = data, input, fields));
                  }
                });
              } else {
                //Search in cached data
                callable(searchArray(cache_data, input, fields));
              }
            }
          }, 500);
        }
      });
    }
    return this;
  };
}(jQuery));

/**
 * Searches an object array
 * @param {array} data Object array to search
 * @param {string} term Term to search for
 * @param {array} fields Fields to search in
 * @returns {Array}
 */
function searchArray(data, term, fields) {
  var found = [];
  var term_regx = term.replace(/ /, '|');
  var split_term_regex = new RegExp(term_regx, 'i');
  var full_term_regex = new RegExp(term, 'i');
  for (var data_key in data) {
    var item = data[data_key];
    for (var field_key in fields) {
      var field = item[fields[field_key]];
      if (field !== undefined) {
        if (field.search(full_term_regex) >= 0) {
          item.weight = 1;
          found.push(item);
        } else if (field.search(split_term_regex) >= 0) {
          item.weight = 0;
          found.push(item);
        }
      }
    }
  }

  return found.sort(function (a, b) {
    if (a.weight === undefined || b.weight === undefined) {
      return 0;
    } else {
      return a.weight > b.weight ? -1 : ((a.weight < b.weight) ? 1 : 0);
    }
  });
}

function monthNames() {
  var month = [];
  month[0] = "January";
  month[1] = "February";
  month[2] = "March";
  month[3] = "April";
  month[4] = "May";
  month[5] = "June";
  month[6] = "July";
  month[7] = "August";
  month[8] = "September";
  month[9] = "October";
  month[10] = "November";
  month[11] = "December";

  return month;
}

function objectSubSet(object, keys) {
  var subSet = {};
  if (keys.length > 0) {
    for (var i in keys) {
      if (keys[i] in object) {
        subSet[keys[i]] = object[keys[i]];
      }
    }
    return subSet;
  }
  return object;
}

function sortObject(obj, field, order) {
  var array = $.map(obj, function (value, index) {
    return [value];
  });
  array.sort(function (a, b) {
    if (order === 'asc') {
      return a[field] - b[field];
    } else {
      return b[field] - a[field];
    }
  });
  return array;
}

/**
 * Make ajax request
 * @param {object} settings This should contain the regular JQuery.ajax settings
 * and optionally <code>onSuccess</code>, <code>onFailure</code> and <code>onComplete</code>
 * closures which are aliases for jqXHR's <code>done</code>, <code>fail</code> and
 * <code>always</code> functions respectively.<br/><br/>
 * <b>Extra configurations</b><br/>
 * ajaxCall takes extra configurations. Add <code>extraConfig</code> object to the settings.<br/>
 * <code>extraConfig</code> properties include:<br/>
 * <b>retry</b> - Set true to resend request if fails due to connectivity, else false.<br/>
 * Note: By default, onComplete will be called after the last trial, to change this,
 * set <code>extraConfig.completeAfterRetry</code> to false.<br/>
 * <b>trials</b> - Maximum number of trials. Set value to 0 for infinite trials<br/>
 * <b>retryInterval</b> - Delay before each retry<br/><br/>
 * <b>Default Values for ajaxCall</b><br/>
 * <code>dataType: 'json'</code><br/>
 * <code>extraConfig: {retry: true,trials: 1,retryInterval: 0,completeAfterRetry: true}</code><br/>
 * @example <code>
 * var jqXHR = ajaxCall({</span><br/>
 * &nbsp;url: 'http://example.com',<br/>
 * &nbsp;data: {p: 'param'},<br/>
 * &nbsp;extraData:{<br/>
 * &nbsp;&nbsp;retry: true,<br/>
 * &nbsp;&nbsp;trials: 2<br/>
 * &nbsp;},<br/>
 * &nbsp;onSuccess: function (data) {<br/>
 * &nbsp;&nbsp;//success<br/>
 * &nbsp;},<br/>
 * &nbsp;onComplete: function () {<br/>
 * &nbsp;&nbsp;//Request complete<br/>
 * &nbsp;},<br/>
 * &nbsp;onFailure: function(){<br/>
 * &nbsp;&nbsp;//Request failed<br/>
 * &nbsp;}<br/>
 *  });
 *</code>
 * @returns {jqXHR} Returns first jqXHR object created
 */
function ajaxCall(settings) {
  var ajaxSettings = {
    dataType: 'json',
    cache: true,
    headers: {
      'Cache-Control': 'max-age=200',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  };
  var extraConfig = {
    retry: true,
    trials: 1,
    retryInterval: 5000,
    completeAfterRetry: true,
    trialCount: 0
  };
  extraConfig = $.extend(extraConfig, settings['extraConfig']);

  //Merge settings
  Object.keys(settings).forEach(function (key) {
    if (key !== 'onSuccess'
      && key !== 'onFailure'
      && key !== 'onComplete'
      && key !== 'extraConfig') {
      var s = [];
      s[key] = settings[key];
      ajaxSettings = $.extend(ajaxSettings, s);
    }
  });

  var r = $.ajax(ajaxSettings);
  if (typeof (settings['onSuccess']) === 'function') {
    r.done(settings['onSuccess']);
  }
  if (typeof (settings['onComplete']) === 'function') {
    (function (completeAfterRetry) {
      r.always(function (jqXHR, status, statusText) {
        if (jqXHR['readyState'] !== 0 || !completeAfterRetry) {
          settings['onComplete'](jqXHR, status, statusText);
        }
      });
    }(extraConfig.completeAfterRetry));
  }
  r.fail(function (response, status, statusText) {
    if (response['status'] === 401) {
      login(settings);
    } else {
      if (response['readyState'] == 0) {
        if (extraConfig['retry']) {
          extraConfig['trialCount']++;
          if (extraConfig['trialCount'] === extraConfig['trials']) {
            extraConfig['retry'] = false;
            extraConfig['completeAfterRetry'] = false;
          }
          //Repeat request
          setTimeout(function () {
            ajaxCall($.extend(settings, {extraConfig: extraConfig}));
          }, extraConfig['retryInterval']);
          return;
        } else {
          Materialize.toast('Connection error', 4000);
        }
      }

      if (typeof (settings['onFailure']) === 'function') {
        settings['onFailure'](response, status, statusText);
      }
    }

  });
  return r;
}

function inView(scrollable, element, offset) {
  if (typeof (offset) !== 'number') {
    offset = 0;
  }
  var scrollTop;
  try {
    scrollTop = $(scrollable).offset().top;
  } catch (exception) {
    scrollTop = 0;
  }

  var docViewTop = $(scrollable).scrollTop();
  var docViewBottom = docViewTop + $(scrollable).height();

  var elemTop = $(element).offset().top - scrollTop - offset;
  var elemBottom = elemTop + $(element).height();
  return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function login(ajaxCallSettings) {
  var form = $('.auth.modal');
  if (form.length > 0) {
    intendRequest = ajaxCallSettings;
    showLoginForm(true);
  } else {
    window.location = 'login';
  }
}

function br2nl(str) {
  return str.replace(/<br\s*\/?>/mg, "\n");
}

function nl2br(str) {
  return str.replace(/\n/g, "<br>");
}

var canvasSupported = [];
function isCanvasSupported(method) {
  if (typeof (canvasSupported[method]) !== 'undefined') {
    return canvasSupported[method];
  } else if (typeof (method) === 'undefined' && typeof (canvasSupported[0]) !== 'undefined') {
    return canvasSupported[0];
  }

  var elem = document.createElement('canvas');
  canvasSupported[0] = !!((elem.getContext) && elem.getContext('2d'));
  if (canvasSupported[0] && !!method) {
    return canvasSupported[method] = typeof (elem[method]) !== 'undefined';
  } else {
    return canvasSupported[0];
  }
}
