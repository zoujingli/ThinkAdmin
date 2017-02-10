!function ($) {
    var Cascade = function (element, options) {
        this.init('cascade', element, options);
    };
    Cascade.prototype = {
        constructor: Cascade,
        init: function (type, element, options) {
            this.type = type;
            this.$element = $(element);
            this.options = this.getOptions(options);
            this.layout();
        }, getOptions: function (options) {
            options = $.extend({}, $.fn[this.type].defaults, this.$element.data(), options);
            return options;
        }, layout: function () {
            $('.additem').remove();
            this.item();
            this.endDecorate();
            this.box();
        }, item: function () {
            var $box = this.$element, _coord = [], _num = 0, _options = this.options, i = 0, $items = $box.find(this.options.fallsCss), fallsWidth = $items.eq(0).outerWidth() + this.options.margin, boxWidth = $box.outerWidth() + this.options.margin, _autoWidth = 0;
            _num = Math.floor(boxWidth / fallsWidth);
            _autoWidth = (boxWidth - _num * fallsWidth) / 2;
            for (; i < _num; i++) {
                _coord.push([i * fallsWidth, 0]);
            }
            $items.each(function () {
                var $item = $(this), fallsHeight = $item.outerHeight() + _options.margin, temp = 0;
                for (i = 0; i < _num; i++) {
                    if (_coord[i][1] < _coord[temp][1]) {
                        temp = i;
                    }
                }
                $item.stop().animate({
                    left: _coord[temp][0] + _autoWidth + 'px', top: _coord[temp][1] + 'px'
                });
                _coord[temp][1] += fallsHeight;
                $item.on('mouseenter' + '.' + _options.type, function () {
                    $(this).addClass('hover');
                });
                $item.on('mouseleave' + '.' + _options.type, function () {
                    $(this).removeClass('hover');
                });
            });
            this.coord = _coord;
            this.num = _num;
            this.autoWidth = _autoWidth;
        }, box: function () {
            this.$element.height(this.getFallsMaxHeight());
        }, endDecorate: function () {
            var _coord = this.coord, i = 0, _num = this.num, fallsMaxHeight = this.getFallsMaxHeight(), falls = document.createElement('div'), fallsClone, fallsHeight = 0;
            falls.className = 'additem';
            for (; i < _num; i++) {
                if (fallsMaxHeight != _coord[i][1]) {
                    fallsClone = falls.cloneNode();
                    fallsHeight = fallsMaxHeight - this.options.margin - _coord[i][1];
                    // fallsClone.style.cssText = 'left: ' + _coord[i][0] + 'px; ' + 'top: ' + _coord[i][1] + 'px; height: ' + fallsHeight + 'px;';
                    this.$element.append($(fallsClone).stop().animate({
                        left: _coord[i][0] + this.autoWidth + 'px', top: _coord[i][1] + 'px', height: fallsHeight + 'px'
                    }));
                }
            }
        }, getFallsMaxHeight: function () {
            var i = 0, heightArry = [], _coord = this.coord, _num = this.num;
            for (; i < _num; i++) {
                heightArry.push(_coord[i][1]);
            }
            heightArry.sort(function (a, b) {
                return a - b;
            });
            return heightArry[_num - 1];
        }
    };
    var old = $.fn.cascade;
    $.fn.cascade = function (option) {
        return this.each(function () {
            var $this = $(this), data = $this.data('cascade'), options = typeof option == 'object' && option;
            if (!data) {
                $this.data('cascade', data = new Cascade(this, options));
                $(window).on('resize.cascade', function () {
                    data['layout']();
                });
            }
            if (typeof option === 'string') {
                data[option]();
            }
        });
    };
    $.fn.cascade.Constructor = Cascade;
    $.fn.cascade.defaults = {
        fallsCss: '.item', margin: 15
    };
    $.fn.cascade.noConflict = function () {
        $.fn.cascade = old;
        return this;
    };
}(window.jQuery);