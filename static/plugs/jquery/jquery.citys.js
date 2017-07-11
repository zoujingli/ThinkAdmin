/**
 * jquery.citys.js 1.0
 * http://jquerywidget.com
 * Github：https://github.com/mumuy/widget
 * -------------- DEMO ---------------
 * $('#demo1').citys({valueType:'name',province:'福建',city:'厦门',area:'思明'});
 */
;(function (factory) {
    if (typeof define === "function" && (define.amd || define.cmd) && !jQuery) {
        // AMD或CMD
        define(["jquery"], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function (root, jQuery) {
            if (jQuery === undefined) {
                if (typeof window !== 'undefined') {
                    jQuery = require('jquery');
                } else {
                    jQuery = require('jquery')(root);
                }
            }
            factory(jQuery);
            return jQuery;
        };
    } else {
        //Browser globals
        factory(jQuery);
    }
}(function ($) {
    $.support.cors = true;
    $.fn.citys = function (parameter, getApi) {
        if (typeof parameter === 'function') { //重载
            getApi = parameter;
            parameter = {};
        } else {
            parameter = parameter || {};
            getApi = getApi || function () {
                };
        }
        var dataUrl = 'http://passer-by.com/data_location/list.json';
        if (window.ROOT_URL) {
            dataUrl = window.ROOT_URL + '/index.php/admin/plugs/region.html';
        }
        var defaults = {
            dataUrl: dataUrl,          //数据库地址
            crossDomain: true,         //是否开启跨域
            dataType: 'json',          //数据库类型:'json'或'jsonp'
            provinceField: 'province', //省份字段名
            cityField: 'city',         //城市字段名
            areaField: 'area',         //地区字段名
            valueType: 'code',         //下拉框值的类型,code行政区划代码,name地名
            code: 0,                   //地区编码
            province: 0,               //省份,可以为地区编码或者名称
            city: 0,                   //城市,可以为地区编码或者名称
            area: 0,                   //地区,可以为地区编码或者名称
            required: true,            //是否必须选一个
            nodata: 'hidden',          //当无数据时的表现形式:'hidden'隐藏,'disabled'禁用,为空不做任何处理
            onChange: function () {    //地区切换时触发,回调函数传入地区数据
            }
        };
        var options = $.extend({}, defaults, parameter);
        return this.each(function () {
            //对象定义
            var _api = {};
            var $this = $(this);
            var $province = $this.find('select[name="' + options.provinceField + '"]'),
                $city = $this.find('select[name="' + options.cityField + '"]'),
                $area = $this.find('select[name="' + options.areaField + '"]');
            $.ajax({
                url: options.dataUrl,
                type: 'GET',
                crossDomain: options.crossDomain,
                dataType: options.dataType,
                jsonpCallback: 'jsonp_location',
                success: function (data) {
                    var province, city, area, hasCity;
                    if (options.code) {   //如果设置地区编码，则忽略单独设置的信息
                        var c = options.code - options.code % 1e4;
                        if (data[c]) {
                            options.province = c;
                        }
                        c = options.code - (options.code % 1e4 ? options.code % 1e2 : options.code);
                        if (data[c]) {
                            options.city = c;
                        }
                        c = options.code % 1e2 ? options.code : 0;
                        if (data[c]) {
                            options.area = c;
                        }
                    }
                    var updateData = function () {
                        province = {}, city = {}, area = {};
                        hasCity = false;       //判断是非有地级城市
                        for (var code in data) {
                            if (!(code % 1e4)) {     //获取所有的省级行政单位
                                province[code] = data[code];
                                if (options.required && !options.province) {
                                    if (options.city && !(options.city % 1e4)) {  //省未填，并判断为直辖市
                                        options.province = options.city;
                                    } else {
                                        options.province = code;
                                    }
                                } else if (isNaN(options.province) && data[code].indexOf(options.province) > -1) {
                                    options.province = code;
                                }
                            } else {
                                var p = code - options.province;
                                if (options.province && p > 0 && p < 1e4) {    //同省的城市或地区
                                    if (!(code % 100)) {
                                        hasCity = true;
                                        city[code] = data[code];
                                        if (options.required && !options.city) {
                                            options.city = code;
                                        } else if (isNaN(options.city) && data[code].indexOf(options.city) > -1) {
                                            options.city = code;
                                        }
                                    } else if (p > 8000) {                 //省直辖县级行政单位
                                        city[code] = data[code];
                                        if (options.required && !options.city) {
                                            options.city = code;
                                        } else if (isNaN(options.city) && data[code].indexOf(options.city) > -1) {
                                            options.city = code;
                                        }
                                    } else if (hasCity) {                  //非直辖市
                                        var c = code - options.city;
                                        if (options.city && c > 0 && c < 100) {     //同个城市的地区
                                            area[code] = data[code];
                                            if (options.required && !options.area) {
                                                options.area = code;
                                            } else if (isNaN(options.area) && data[code].indexOf(options.area) > -1) {
                                                options.area = code;
                                            }
                                        }
                                    } else {
                                        area[code] = data[code];            //直辖市
                                        if (options.required && !options.area) {
                                            options.area = code;
                                        } else if (isNaN(options.area) && data[code].indexOf(options.area) > -1) {
                                            options.area = code;
                                        }
                                    }
                                }
                            }
                        }
                    };
                    var format = {
                        province: function () {
                            $province.empty();
                            if (!options.required) {
                                $province.append('<option value=""> - 请选择 - </option>');
                            }
                            for (var i in province) {
                                $province.append('<option value="' + (options.valueType === 'code' ? i : province[i]) + '" data-code="' + i + '">' + province[i] + '</option>');
                            }
                            if (options.province) {
                                var value = options.valueType === 'code' ? options.province : province[options.province];
                                $province.val(value);
                            }
                            this.city();
                        },
                        city: function () {
                            $city.empty();
                            if (!hasCity) {
                                $city.css('display', 'none');
                            } else {
                                $city.css('display', '');
                                if (!options.required) {
                                    $city.append('<option value=""> - 请选择 - </option>');
                                }
                                if (options.nodata === 'disabled') {
                                    $city.prop('disabled', $.isEmptyObject(city));
                                } else if (options.nodata === 'hidden') {
                                    $city.css('display', $.isEmptyObject(city) ? 'none' : '');
                                }
                                for (var i in city) {
                                    $city.append('<option value="' + (options.valueType === 'code' ? i : city[i]) + '" data-code="' + i + '">' + city[i] + '</option>');
                                }
                                if (options.city) {
                                    var value = options.valueType === 'code' ? options.city : city[options.city];
                                    $city.val(value);
                                } else if (options.area) {
                                    var value = options.valueType === 'code' ? options.area : city[options.area];
                                    $city.val(value);
                                }
                            }
                            this.area();
                        },
                        area: function () {
                            $area.empty();
                            if (!options.required) {
                                $area.append('<option value=""> - 请选择 - </option>');
                            }
                            if (options.nodata === 'disabled') {
                                $area.prop('disabled', $.isEmptyObject(area));
                            } else if (options.nodata === 'hidden') {
                                $area.css('display', $.isEmptyObject(area) ? 'none' : '');
                            }
                            for (var i in area) {
                                $area.append('<option value="' + (options.valueType === 'code' ? i : area[i]) + '" data-code="' + i + '">' + area[i] + '</option>');
                            }
                            if (options.area) {
                                var value = options.valueType === 'code' ? options.area : area[options.area];
                                $area.val(value);
                            }
                        }
                    };
                    //获取当前地理信息
                    _api.getInfo = function () {
                        var status = {
                            direct: !hasCity,
                            province: data[options.province] || '',
                            city: data[options.city] || '',
                            area: data[options.area] || '',
                            code: options.area || options.city || options.province
                        };
                        return status;
                    };
                    //事件绑定
                    $province.on('change', function () {
                        options.province = $(this).find('option:selected').data('code') || 0; //选中节点的区划代码
                        options.city = 0;
                        options.area = 0;
                        updateData();
                        format.city();
                        options.onChange(_api.getInfo());
                    });
                    $city.on('change', function () {
                        options.city = $(this).find('option:selected').data('code') || 0; //选中节点的区划代码
                        options.area = 0;
                        updateData();
                        format.area();
                        options.onChange(_api.getInfo());
                    });
                    $area.on('change', function () {
                        options.area = $(this).find('option:selected').data('code') || 0; //选中节点的区划代码
                        options.onChange(_api.getInfo());
                    });
                    //初始化
                    updateData();
                    format.province();
                    if (options.code) {
                        options.onChange(_api.getInfo());
                    }
                    getApi(_api);
                }
            });
        });
    };
}));
