/**
 * 仿element-ui，级联选择器
 * 已实现单选、多选、无关联选择
 * 其他功能：组件禁用、节点禁用、自定义属性、自定义空面板提示，自定义无选择时的提示、多选标签折叠、回显、搜索、动态加载、最大选中数量限制、禁用项固定等操作。
 * element-ui没有的功能：最大选中数量限制、禁用项固定
 * author: yixiaco
 * gitee: https://gitee.com/yixiacoco/lay_cascader
 * github: https://github.com/yixiaco/lay_cascader
 */
layui.define(["jquery"], function (exports) {
    var $ = layui.jquery;

    /**
     * 级联各项节点对象
     * @param data        原始对象信息
     * @param cascader    级联对象
     * @param level       层级，从0开始
     * @param parentNode 父节点对象
     * @constructor
     */
    function Node(data, cascader, level, parentNode) {
        this.data = data;
        this.cascader = cascader;
        this.config = cascader.config;
        this.props = cascader.props;
        this.level = level;
        this.parentNode = parentNode;
        // 引入的icon图标
        this.icons = cascader.icons;
        //该节点是否被选中 0:未选中，1：选中，2：不定
        this._checked = 0;
        // 是否正在加载中
        this._loading = false;
        // 每个Node的唯一标识
        this.nodeId = cascader.data.nodeId++;
    }

    Node.prototype = {
        constructor: Node,
        /** 最顶级父节点 */
        get topParentNode() {
            return !this.parentNode && this || this.topParentNode;
        },
        /** 子节点 */
        childrenNode: undefined,
        get loading() {
            return this._loading;
        },
        set loading(loading) {
            var $li = this.$li;
            if ($li) {
                var rightIcon = this.icons.right;
                var loadingIcon = this.icons.loading;
                var $i = $li.find('i');
                if (loading) {
                    $i.addClass(loadingIcon);
                    $i.removeClass(rightIcon);
                } else {
                    $i.addClass(rightIcon);
                    $i.removeClass(loadingIcon);
                }
            }
            return this._loading = loading;
        },
        /** 当前节点的显示文本 */
        get label() {
            return this.data[this.props.label];
        },
        /** 当前节点的值 */
        get value() {
            return this.data[this.props.value];
        },
        /** 是否禁用 */
        get disabled() {
            var multiple = this.props.multiple;
            var maxSize = this.config.maxSize;
            var checkedNodeIds = this.cascader.data.checkedNodeIds;
            var disabledName = this.props.disabled;
            var checkStrictly = this.props.checkStrictly;
            // 检查是否超过最大值限制
            if (multiple && maxSize !== 0) {
                if (checkedNodeIds.length >= maxSize && checkedNodeIds.indexOf(this.nodeId) === -1) {
                    // 如果是关联的多选，需要查询叶子节点是否有被选中的项
                    if (!checkStrictly) {
                        var leafChildren = this.getAllLeafChildren();
                        var nodeIds = leafChildren.map(function (value) {
                            return value.nodeId
                        });
                        // 如果叶子节点不包含，则直接返回true
                        if (!nodeIds.some(function (nodeId) {
                            return checkedNodeIds.indexOf(nodeId) !== -1;
                        })) {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            }
            if (!checkStrictly) {
                var path = this.path;
                return path.some(function (node) {
                    return node.data[disabledName];
                });
            } else {
                return this.data[disabledName];
            }
        },
        /** 子节点数据 */
        get children() {
            return this.data[this.props.children];
        },
        set children(children) {
            this.data[this.props.children] = children;
        },
        /** 叶子节点 */
        get leaf() {
            var leaf = this.data[this.props.leaf];
            if (typeof leaf === 'boolean') {
                return leaf;
            }
            // 如果children不为空,则判断是否是子节点
            if (this.children) {
                return this.children.length <= 0;
            }
            return true;
        },
        /** 当前单选值 */
        get activeNodeId() {
            return this.cascader.data.activeNodeId;
        },
        /** 当前复选框值 */
        get checkedNodeIds() {
            return this.cascader.data.checkedNodeIds;
        },
        /** 路径 */
        get path() {
            var parentNode = this.parentNode;
            if (parentNode) {
                return parentNode.path.concat([this]);
            } else {
                return [this];
            }
        },
        /** 是否正在搜索中 */
        get isFiltering() {
            return this.cascader.isFiltering;
        },
        /** 输入框的tag标签 */
        get $tag() {
            var cascader = this.cascader;
            var showAllLevels = this.config.showAllLevels;
            var disabled = this.config.disabled;
            var nodeDisabled = this.disabled;
            var disabledFixed = this.config.disabledFixed;

            var label = this.getPathLabel(showAllLevels);
            var $tag = cascader.get$tag(label, !disabled && (!nodeDisabled || !disabledFixed));
            var self = this;
            $tag.find('i').click(function (event) {
                event.stopPropagation();
                self.selectedValue();
                cascader.removeTag(self.value, self);
            });
            return $tag;
        },
        /**
         * 完整路径的标签
         * @param showAllLevels
         * @returns {string}
         */
        getPathLabel: function (showAllLevels) {
            var path = this.path;
            var separator = this.config.separator;

            var label;
            if (showAllLevels) {
                label = path.map(function (node) {
                    return node.label;
                }).join(separator);
            } else {
                label = path[path.length - 1].label;
            }
            return label;
        },
        /**
         * 初始化
         */
        init: function () {
            var multiple = this.props.multiple;
            var checkStrictly = this.props.checkStrictly;
            var fromIcon = this.icons.from;
            var rightIcon = this.icons.right;
            var icon = '';
            var label = this.label;
            if (!this.leaf) {
                icon = rightIcon;
            }
            this.$li = $('<li role="menuitem" id="cascader-menu" tabindex="-1" class="el-cascader-node" aria-haspopup="true" aria-owns="cascader-menu"><span class="el-cascader-node__label">' + label + '</span><i class="' + fromIcon + ' ' + icon + '"></i></li>');

            // 节点渲染
            if (!multiple && !checkStrictly) {
                this._renderRadio();
            } else if (!multiple && checkStrictly) {
                this._renderRadioCheckStrictly();
            } else if (multiple && !checkStrictly) {
                this._renderMultiple();
            } else if (multiple && checkStrictly) {
                this._renderMultipleCheckStrictly();
            }
        },
        /**
         * 初始化可搜索li
         */
        initSuggestionLi: function () {
            var label = this.getPathLabel(true);
            this.$suggestionLi = $('<li tabindex="-1" class="el-cascader__suggestion-item"><span>' + label + '</span></li>');
            // 节点渲染
            this._renderFiltering();
        },
        /**
         * 绑定到菜单中
         * @param $list li节点
         */
        bind: function ($list) {
            this.init();
            $list.append(this.$li);
        },
        /**
         * 绑定可搜索到列表中
         * @param $list
         */
        bindSuggestion: function ($list) {
            this.initSuggestionLi();
            $list.append(this.$suggestionLi);
        },
        /**
         * 可搜索渲染
         * @private
         */
        _renderFiltering: function () {
            var $li = this.$suggestionLi;
            var nodeId = this.nodeId;
            var fromIcon = this.icons.from;
            var okIcon = this.icons.ok;
            var self = this;
            var cascader = this.cascader;
            var multiple = this.props.multiple;

            var icon = '<i class="' + fromIcon + ' ' + okIcon + ' el-icon-check"></i>';
            $li.click(function (event) {
                event.stopPropagation();
                self.selectedValue();
                if (multiple) {
                    if (self.checkedNodeIds.indexOf(nodeId) === -1) {
                        $li.removeClass('is-checked');
                        $li.find('.el-icon-check').remove();
                    } else {
                        $li.addClass('is-checked');
                        $li.append(icon);
                    }
                } else {
                    // 关闭面板
                    cascader.close();
                }
            });

            if (multiple && self.checkedNodeIds.indexOf(nodeId) !== -1
                || !multiple && self.activeNodeId === nodeId) {
                $li.addClass('is-checked');
                $li.append(icon)
            }
        },
        /**
         * 单选&&关联
         * @private
         */
        _renderRadio: function () {
            var $li = this.$li;
            var nodeId = this.nodeId;
            var fromIcon = this.icons.from;
            var okIcon = this.icons.ok;
            var level = this.level;
            var leaf = this.leaf;
            var self = this;
            var cascader = this.cascader;
            var activeNode = this.cascader.data.activeNode;
            var parentNode = this.parentNode;

            if (self.activeNodeId && activeNode.path.some(function (node) {
                return node.nodeId === nodeId;
            })) {
                if (self.activeNodeId === nodeId) {
                    $li.prepend('<i class="' + fromIcon + ' ' + okIcon + ' el-cascader-node__prefix"></i>');
                }
                $li.addClass('is-active');
                $li.addClass('in-checked-path');
            }

            // 是否禁用
            if (this.disabled) {
                $li.addClass('is-disabled');
                return;
            }

            $li.addClass('is-selectable');

            if (parentNode) {
                parentNode.$li.siblings().removeClass('in-active-path');
                parentNode.$li.addClass('in-active-path');
            }

            // 触发下一个节点
            this._liClick(function (event) {
                event.stopPropagation();
                var childrenNode = self.childrenNode;
                if (leaf && event.type === 'click') {
                    self.selectedValue();
                    // 关闭面板
                    cascader.close();
                }
                // 添加下级菜单
                cascader._appendMenu(childrenNode, level + 1, self);
            });
        },
        /**
         * 单选&&非关联
         * @private
         */
        _renderRadioCheckStrictly: function () {
            var $li = this.$li;
            var nodeId = this.nodeId;
            var level = this.level;
            var leaf = this.leaf;
            var self = this;
            var cascader = this.cascader;
            var activeNode = cascader.data.activeNode;
            var parentNode = this.parentNode;

            $li.addClass('is-selectable');
            // 任意一级单选
            var $radio = $('<label role="radio" tabindex="0" class="el-radio"><span class="el-radio__input"><span class="el-radio__inner"></span><input type="radio" aria-hidden="true" tabindex="-1" class="el-radio__original" value="' + nodeId + '"></span><span class="el-radio__label"><span></span></span></label>');
            this.$radio = $radio;
            $li.prepend($radio);
            if (parentNode) {
                parentNode.$li.siblings().removeClass('in-active-path');
                parentNode.$li.addClass('in-active-path');
            }

            // 触发下一个节点
            this._liClick(function (event) {
                event.stopPropagation();
                var childrenNode = self.childrenNode;
                if (!self.disabled && leaf && event.type === 'click') {
                    self.selectedValue();
                }
                // 添加下级菜单
                cascader._appendMenu(childrenNode, level + 1, self);
            });

            if (self.activeNodeId && activeNode.path.some(function (node) {
                return node.nodeId === nodeId;
            })) {
                if (self.activeNodeId === nodeId) {
                    $radio.find('.el-radio__input').addClass('is-checked');
                }
                $li.addClass('is-active');
                $li.addClass('in-checked-path');
            }

            if (this.disabled) {
                $radio.addClass('is-disabled');
                $radio.find('.el-radio__input').addClass('is-disabled');
                return;
            }
            // 选中事件
            $radio.click(function (event) {
                event.preventDefault();
                !leaf && self.selectedValue();
            });
        },
        /**
         * 多选&&关联
         * @private
         */
        _renderMultiple: function () {
            var $li = this.$li;
            var level = this.level;
            var leaf = this.leaf;
            var self = this;
            var cascader = this.cascader;
            var checked = this._checked;
            var parentNode = this.parentNode;

            $li.addClass('el-cascader-node');

            // 多选框
            var $checked = $('<label class="el-checkbox"><span class="el-checkbox__input"><span class="el-checkbox__inner"></span><input type="checkbox" aria-hidden="false" class="el-checkbox__original" value=""></span></label>');
            this.$checked = $checked;
            $li.prepend($checked);

            // 渲染
            if (checked === 1) {
                this.$checked.find('.el-checkbox__input').addClass('is-checked');
            } else if (checked === 2) {
                this.$checked.find('.el-checkbox__input').addClass('is-indeterminate');
            }

            if (parentNode) {
                parentNode.$li.siblings().removeClass('in-active-path');
                parentNode.$li.addClass('in-active-path');
            }

            // 触发下一个节点
            this._liClick(function (event) {
                event.stopPropagation();
                var childrenNode = self.childrenNode;
                if (!self.disabled && leaf && event.type === 'click') {
                    // 最后一级就默认选择
                    self.selectedValue();
                }
                // 添加下级菜单
                cascader._appendMenu(childrenNode, level + 1, self);
            });

            if (this.disabled) {
                $li.addClass('is-disabled');
                $checked.addClass('is-disabled');
                $checked.find('.el-checkbox__input').addClass('is-disabled');
                return;
            }

            // 选中事件
            $checked.click(function (event) {
                event.preventDefault();
                if (!leaf) {
                    var childrenNode = self.childrenNode;
                    self.selectedValue();
                    cascader._appendMenu(childrenNode, level + 1, self);
                }
            });
        },
        /**
         * 多选&&非关联
         * @private
         */
        _renderMultipleCheckStrictly: function () {
            var $li = this.$li;
            var level = this.level;
            var leaf = this.leaf;
            var self = this;
            var cascader = this.cascader;
            var checkedNodeIds = cascader.data.checkedNodeIds;
            var checkedNodes = cascader.data.checkedNodes;
            var nodeId = this.nodeId;
            var parentNode = this.parentNode;

            $li.addClass('el-cascader-node is-selectable');

            // 多选框
            var $checked = $('<label class="el-checkbox"><span class="el-checkbox__input"><span class="el-checkbox__inner"></span><input type="checkbox" aria-hidden="false" class="el-checkbox__original" value=""></span></label>');
            this.$checked = $checked;
            $li.prepend($checked);

            // 渲染
            var exist = checkedNodes.some(function (node) {
                return node.path.some(function (node) {
                    return node.nodeId === nodeId;
                })
            });
            if (exist) {
                $li.addClass('in-checked-path');
                if (checkedNodeIds.indexOf(nodeId) !== -1) {
                    this.$checked.find('.el-checkbox__input').addClass('is-checked');
                }
            }

            if (parentNode) {
                parentNode.$li.siblings().removeClass('in-active-path');
                parentNode.$li.addClass('in-active-path');
            }

            // 触发下一个节点
            this._liClick(function (event) {
                event.stopPropagation();
                var childrenNode = self.childrenNode;
                if (!self.disabled && leaf && event.type === 'click') {
                    // 最后一级就默认选择
                    self.selectedValue();
                }
                // 添加下级菜单
                cascader._appendMenu(childrenNode, level + 1, self);
            });

            if (this.disabled) {
                $checked.addClass('is-disabled');
                $checked.find('.el-checkbox__input').addClass('is-disabled');
                return;
            }
            // 选中事件
            $checked.click(function (event) {
                event.preventDefault();
                if (!leaf) {
                    self.selectedValue();
                    var childrenNode = self.childrenNode;
                    // 添加下级菜单
                    cascader._appendMenu(childrenNode, level + 1, self);
                }
            });
        },
        /**
         * 向上传递
         * @param callback 执行方法，如果返回false，则中断执行
         * @param advance 是否先执行一次
         * @param self  自身
         */
        transferParent: function (callback, advance, self) {
            if (!self) {
                self = this;
            }
            if (this !== self || advance) {
                var goOn = callback && callback(this);
                if (goOn === false) {
                    return;
                }
            }
            this.parentNode && this.parentNode.transferParent(callback, advance, self);
        },
        /**
         * 向下传递
         * @param callback 执行的方法，如果返回false，则中断执行
         * @param advance 是否先执行一次
         * @param self  自身
         */
        transferChildren: function (callback, advance, self) {
            if (!self) {
                self = this;
            }
            if (this !== self || advance) {
                var goOn = callback && callback(this);
                if (goOn === false) {
                    return;
                }
            }
            var children = this.getChildren();
            if (children && children.length > 0) {
                for (var index in children) {
                    children[index].transferChildren(callback, advance, self);
                }
            }
        },
        /**
         * 设置级联值
         */
        selectedValue: function () {
            var nodeId = this.nodeId;
            var cascader = this.cascader;
            var multiple = this.props.multiple;
            var checkStrictly = this.props.checkStrictly;
            var leaf = this.leaf;
            if (!multiple && (leaf || checkStrictly)) {
                cascader._setActiveValue(nodeId, this);
            } else if (multiple) {
                var checkedNodeIds = cascader.data.checkedNodeIds;
                var checkedNodes = cascader.data.checkedNodes;
                var disabledFixed = this.config.disabledFixed;
                var paths;
                if (checkStrictly) {
                    var index = checkedNodeIds.indexOf(nodeId);
                    if (index === -1) {
                        paths = checkedNodes.concat([this]);
                    } else {
                        paths = checkedNodes.concat();
                        paths.splice(index, 1);
                    }
                } else {
                    var allLeafChildren = this.getAllLeafChildren();
                    var checked;
                    if (this._checked !== 1 && disabledFixed) {
                        checked = this._getMultipleChecked(allLeafChildren);
                    } else {
                        checked = this._checked;
                    }
                    if (checked === 1) {
                        // 选中->未选中
                        paths = checkedNodes.filter(function (node1) {
                            return !allLeafChildren.some(function (node2) {
                                return node1.nodeId === node2.nodeId;
                            });
                        });
                    } else {
                        // 未选中、部分选中->选中
                        var add = allLeafChildren.filter(function (node) {
                            return checkedNodeIds.indexOf(node.nodeId) === -1;
                        });
                        paths = checkedNodes.concat(add);
                    }
                }
                var nodeIds = paths.map(function (node) {
                    return node.nodeId;
                });
                cascader._setCheckedValue(nodeIds, paths);
            }
        },
        _liLoad: function (event, callback) {
            var leaf = this.leaf;
            var lazy = this.props.lazy;
            var lazyLoad = this.props.lazyLoad;
            var children = this.children;
            var self = this;
            var cascader = this.cascader;
            var level = this.level;
            var multiple = this.props.multiple;
            var checkStrictly = this.props.checkStrictly;
            if (!leaf && (!children || children.length === 0) && lazy) {
                if (!self.loading) {
                    self.loading = true;
                    lazyLoad(self, function (nodes) {
                        self.loading = false;
                        self.setChildren(cascader.initNodes(nodes, level + 1, self));
                        self.children = nodes;
                        callback && callback(event);
                        // 多选&关联时，重新同步下父级节点的样式
                        multiple && !checkStrictly && self.transferParent(function (node) {
                            node.syncStyle();
                        }, true);
                    });
                }
            } else {
                callback && callback(event);
            }
        },
        /**
         * 点击li事件
         * @param callback
         * @private
         */
        _liClick: function (callback) {
            var leaf = this.leaf;
            var $li = this.$li;
            var self = this;

            function load(event) {
                self._liLoad(event, callback);
            }

            if (this.props.expandTrigger === "click" || leaf) {
                $li.click(load);
            }
            if (this.props.expandTrigger === "hover") {
                $li.mouseenter(load);
            }
        },
        setChildren: function (children) {
            this.childrenNode = children;
        },
        getChildren: function () {
            return this.childrenNode;
        },
        /**
         * 同步样式
         */
        syncStyle: function () {
            var multiple = this.props.multiple;
            var checkStrictly = this.props.checkStrictly;
            if (multiple) {
                //多选
                if (checkStrictly) {
                    this._sync.syncMultipleCheckStrictly(this);
                } else {
                    this._sync.syncMultiple(this);
                }
            } else {
                //单选
                if (checkStrictly) {
                    this._sync.syncRadioCheckStrictly(this);
                } else {
                    this._sync.syncRadio(this);
                }
            }
        },
        /**
         * 同步本节点样式
         */
        _sync: {
            /**
             * 同步单选关联样式
             */
            syncRadio: function (self) {
                var $li = self.$li;
                var fromIcon = self.icons.from;
                var okIcon = self.icons.ok;
                var multiple = self.props.multiple;
                var checkStrictly = self.props.checkStrictly;
                var nodeId = self.nodeId;
                if (!$li || multiple || checkStrictly) {
                    return;
                }
                var activeNode = self.cascader.data.activeNode;
                if (self.activeNodeId === nodeId) {
                    var ok = $li.find('.' + okIcon);
                    if (ok.length === 0) {
                        $li.prepend('<i class="' + fromIcon + ' ' + okIcon + ' el-cascader-node__prefix"></i>');
                    }
                } else {
                    $li.find('.' + okIcon).remove();
                }
                if (activeNode && activeNode.path.some(function (node) {
                    return node.nodeId === nodeId;
                })) {
                    $li.addClass('is-active');
                    $li.addClass('in-checked-path');
                } else {
                    $li.removeClass('is-active');
                    $li.removeClass('in-checked-path');
                }
            },
            /**
             * 同步单选非关联样式
             */
            syncRadioCheckStrictly: function (self) {
                var $li = self.$li;
                var checkStrictly = self.props.checkStrictly;
                var multiple = self.props.multiple;
                if (!$li || multiple || !checkStrictly) {
                    return;
                }
                var $radio = self.$radio;
                var activeNode = self.cascader.data.activeNode;
                var nodeId = self.nodeId;
                if (self.activeNodeId === nodeId) {
                    $radio.find('.el-radio__input').addClass('is-checked');
                } else {
                    $radio.find('.el-radio__input').removeClass('is-checked');
                }
                if (activeNode && activeNode.path.some(function (node) {
                    return node.nodeId === nodeId;
                })) {
                    $li.addClass('is-active');
                    $li.addClass('in-checked-path');
                } else {
                    $li.removeClass('is-active');
                    $li.removeClass('in-checked-path');
                }
            },
            /**
             * 同步多选关联样式
             */
            syncMultiple: function (self) {
                var $li = self.$li;
                var checkStrictly = self.props.checkStrictly;
                var multiple = self.props.multiple;
                var disabledFixed = self.config.disabledFixed;
                if (!multiple || checkStrictly) {
                    return;
                }
                var allLeafChildren = self.getAllLeafChildren(disabledFixed);
                // 全部未选中 0
                // 全部选中 1
                // 部分选中 2
                var checked = self._getMultipleChecked(allLeafChildren);
                self._checked = checked;
                if (!$li) {
                    return;
                }
                var $checkbox = self.$checked.find('.el-checkbox__input');
                if (checked === 0) {
                    $checkbox.removeClass('is-checked');
                    $checkbox.removeClass('is-indeterminate');
                } else if (checked === 1) {
                    $checkbox.removeClass('is-indeterminate');
                    $checkbox.addClass('is-checked');
                } else if (checked === 2) {
                    $checkbox.removeClass('is-checked');
                    $checkbox.addClass('is-indeterminate');
                }
            },
            /**
             * 同步多选非关联样式
             */
            syncMultipleCheckStrictly: function (self) {
                var $li = self.$li;
                var checkStrictly = self.props.checkStrictly;
                var multiple = self.props.multiple;
                if (!$li || !multiple || !checkStrictly) {
                    return;
                }
                var checkedNodes = self.cascader.data.checkedNodes;
                var checkedNodeIds = self.checkedNodeIds;
                var nodeId = self.nodeId;
                var exist = checkedNodes.some(function (node) {
                    return node.path.some(function (node) {
                        return node.nodeId === nodeId;
                    });
                });
                var $checkbox = self.$checked.find('.el-checkbox__input');
                if (checkedNodeIds.some(function (checkedNodeId) {
                    return checkedNodeId === nodeId;
                })) {
                    // 选中
                    $checkbox.addClass('is-checked');
                } else {
                    // 未选中
                    $checkbox.removeClass('is-checked');
                }
                if (exist) {
                    $li.addClass('in-checked-path');
                } else {
                    $li.removeClass('in-checked-path');
                }
            }
        },
        /**
         * 获取叶子节点value值
         * @param disabled 是否包含禁用,默认不包含
         * @returns {Node[]|*[]}
         */
        getAllLeafChildren: function (disabled) {
            var leaf = this.leaf;
            if (leaf) {
                return [this];
            } else {
                var leafs = [];
                this.transferChildren(function (node) {
                    if (node.disabled && !disabled) {
                        return false;
                    }
                    node.leaf && leafs.push(node);
                });
                return leafs;
            }
        },
        /**
         * 展开当前节点
         */
        expandPanel: function () {
            var path = this.path;
            var cascader = this.cascader;
            path.forEach(function (node, index, array) {
                if (index !== array.length - 1) {
                    var childrenNode = node.childrenNode;
                    cascader._appendMenu(childrenNode, node.level + 1, node.parentNode);
                }
            });
        },
        _getMultipleChecked: function (leafNodes) {
            var cascader = this.cascader;
            var checkedNodeIds = cascader.data.checkedNodeIds;
            var allLeafIds = leafNodes.map(function (node) {
                return node.nodeId;
            });
            // 全部未选中 0
            // 全部选中 1
            // 部分选中 2
            var checked = 0;
            for (var i = 0; i < allLeafIds.length; i++) {
                var child = allLeafIds[i];
                if (checked === 2) {
                    break;
                }
                if (checkedNodeIds.indexOf(child) !== -1) {
                    if (i > 0 && checked !== 1) {
                        checked = 2;
                    } else {
                        checked = 1;
                    }
                } else {
                    // 当全部选中时，则改为部分选中，否则全部未选中
                    checked = checked === 1 ? 2 : 0;
                }
            }
            return checked;
        }
    };

    function Cascader(config) {
        this.config = $.extend(true, {
            elem: '',             //绑定元素
            value: null,          //预设值
            options: [],          //可选项数据源，键名可通过 Props 属性配置
            empty: '暂无数据',	  //无匹配选项时的内容
            placeholder: '请选择',//输入框占位文本
            disabled: false,      //是否禁用
            clearable: false,     //是否支持清空选项
            showAllLevels: true,  //输入框中是否显示选中值的完整路径
            collapseTags: false,  //多选模式下是否折叠Tag
            minCollapseTagsNumber: 1, //最小折叠标签数
            separator: ' / ',     //选项分隔符
            filterable: false,    //是否可搜索选项
            filterMethod: function (node, keyword) {
                return node.path.some(function (node) {
                    return node.label.indexOf(keyword) !== -1;
                });
            }, //自定义搜索逻辑，第一个参数是节点node，第二个参数是搜索关键词keyword，通过返回布尔值表示是否命中
            debounce: 300,        //搜索关键词输入的去抖延迟，毫秒
            beforeFilter: function (value) {
                return true;
            },//筛选之前的钩子，参数为输入的值，若返回 false,则停止筛选
            popperClass: '',        //	自定义浮层类名	string
            extendClass: false,     //继承class样式
            extendStyle: false,     //继承style样式
            disabledFixed: false,   //固定禁用项，使禁用项不被清理删除，禁用项只能通过函数添加或初始值添加,默认禁用项不可被函数或初始值添加
            maxSize: 0,           // 多选选中的最大数量，0表示不限制
            props: {
                strictMode: false,      //严格模式，设置value严格按照层级结构.例如：[[1,2,3],[1,2,4]]
                expandTrigger: 'click', //次级菜单的展开方式	string	click / hover	'click'
                multiple: false,	      //是否多选	boolean	-	false
                checkStrictly: false, 	//是否严格的遵守父子节点不互相关联	boolean	-	false
                lazy: false,	        //是否动态加载子节点，需与 lazyLoad 方法结合使用	boolean	-	false
                lazyLoad: function (node, resolve) {
                },	//加载动态数据的方法，仅在 lazy 为 true 时有效	function(node, resolve)，node为当前点击的节点，resolve为数据加载完成的回调(必须调用)
                value: 'value',	        //指定选项的值为选项对象的某个属性值	string	—	'value'
                label: 'label',	        //指定选项标签为选项对象的某个属性值	string	—	'label'
                children: 'children',	  //指定选项的子选项为选项对象的某个属性值	string	—	'children'
                disabled: 'disabled',   //指定选项的禁用为选项对象的某个属性值	string	—	'disabled'
                leaf: 'leaf'	          //指定选项的叶子节点的标志位为选项对象的某个属性值	string	—	'leaf'
            }
        }, config);
        this.data = {
            nodeId: 1,            //nodeId的自增值
            nodes: [],            //存储Node对象
            menuData: [],         //压入菜单的数据
            activeNodeId: null,   //存放NodeId
            activeNode: null,     //存放Node
            checkedNodeIds: [],   //存放多个NodeId
            checkedNodes: []  //存放多个Node
        };
        // 面板是否展开
        this.showPanel = false;
        this.event = {
            // 值变更事件
            change: [],
            // 打开事件
            open: [],
            // 关闭事件
            close: []
        }
        // 是否正在搜索中
        this.filtering = false;
        // 初始化
        this._init();
        // 面板关闭事件id
        this.closeEventId = 0;
        // 是否进入maxSize模式
        this._maxSizeMode = false;
    }

    Cascader.prototype = {
        constructor: Cascader,
        get props() {
            return this.config.props;
        },
        get isFiltering() {
            return this.filtering;
        },
        set isFiltering(filtering) {
            if (this.filtering === filtering) {
                return;
            }
            this.filtering = !!filtering;
            var $panel = this.$panel;
            if (this.filtering) {
                $panel.find('.el-cascader-panel').hide();
                $panel.find('.el-cascader__suggestion-panel').show();
            } else {
                $panel.find('.el-cascader-panel').show();
                $panel.find('.el-cascader__suggestion-panel').hide();
                this.$tagsInput && this.$tagsInput.val('')
            }
        },
        set maxSizeMode(maxSizeMode) {
            if (this._maxSizeMode !== maxSizeMode) {
                this._maxSizeMode = maxSizeMode;
                this.refreshMenu();
            }
        },
        icons: {
            from: 'layui-icon',
            down: 'layui-icon-down',
            close: 'layui-icon-close',
            right: 'layui-icon-right',
            ok: 'layui-icon-ok',
            loading: 'layui-icon-loading-1 layui-anim layui-anim-rotate layui-anim-loop'
        },
        // 初始化
        _init: function () {
            this._checkConfig();
            // 初始化输入框
            this._initInput();
            // 初始化面板
            this._initPanel();
            // 初始化选项值
            this.setOptions(this.config.options);
            var self = this;
            // 监听滚动条
            $(window).scroll(function () {
                self._resetXY();
            });
            // 监听窗口
            $(window).resize(function () {
                self._resetXY();
            });
            // 点击事件，展开面板
            this.$div.click(function (event) {
                if (self.config.disabled) {
                    return;
                }
                var show = self.showPanel;
                if (!show) {
                    self.open();
                } else {
                    self.close();
                }
            });
        },
        /**
         * 检查配置
         * @private
         */
        _checkConfig: function () {
            var elem = this.config.elem;
            if (!elem || $(elem).length === 0) {
                throw new Error("缺少elem节点选择器");
            }
            var maxSize = this.config.maxSize;
            if (typeof maxSize !== 'number' || maxSize < 0) {
                throw new Error("maxSize应是一个大于等于0的有效的number值");
            }
            if (!Array.isArray(this.config.options)) {
                throw new Error("options不是一个有效的数组");
            }
        },
        /**
         * 初始化根目录
         * @private
         */
        _initRoot: function () {
            var lazy = this.props.lazy;
            var lazyLoad = this.props.lazyLoad;
            var self = this;
            var nodes = this.data.nodes;
            if (nodes.length > 0 || !lazy) {
                this._appendMenu(nodes, 0);
            } else if (lazy) {
                this._appendMenu(nodes, 0);
                lazyLoad({
                    root: true,
                    level: 0
                }, function (nodes) {
                    self.data.nodes = self.initNodes(nodes, 0, null);
                    self._appendMenu(self.data.nodes, 0);
                });
            }
        },
        /**
         * 设置选项值
         * @param options
         */
        setOptions: function (options) {
            this.config.options = options;
            // 初始化节点
            this.data.nodes = this.initNodes(options, 0, null);
            // 初始化根目录
            this._initRoot();
            // 初始化值
            this.setValue(this.config.value);
        },
        // 面板定位
        _resetXY: function () {
            var $div = this.$div;
            var offset = $div.offset();
            var $panel = this.$panel;
            if ($panel) {
                var windowHeight = window.innerHeight;
                var windowWidth = window.innerWidth;
                var panelHeight = $panel.height();
                var panelWidth = $panel.width();
                var divHeight = $div.height();
                var boundingClientRect = $div[0].getBoundingClientRect();
                var $arrow = $panel.find('.popper__arrow');

                // 距离右边界的偏差值
                var offsetDiff = Math.min(windowWidth - boundingClientRect.x - panelWidth - 5, 0);

                var bottomHeight = windowHeight - (boundingClientRect.top + divHeight);
                if (bottomHeight < panelHeight && boundingClientRect.top > panelHeight + 20) {
                    $panel.attr('x-placement', 'top-start')
                    // 向上
                    $panel.css({
                        top: offset.top - 20 - panelHeight + 'px',
                        left: offset.left + offsetDiff + 'px'
                    });
                } else {
                    $panel.attr('x-placement', 'bottom-start');
                    // 距离底部边界的偏差值
                    var yOffset = Math.max(panelHeight - (windowHeight - boundingClientRect.y - divHeight - 15), 0);
                    // 向下
                    $panel.css({
                        top: offset.top + divHeight - yOffset + 'px',
                        left: offset.left + offsetDiff + 'px'
                    });
                }
                // 箭头偏移
                $arrow.css("left", 35 - offsetDiff + "px");
            }
        },
        get $menus() {
            return this.$panel && this.$panel.find('.el-cascader-panel .el-cascader-menu');
        },
        // 初始化输入框
        _initInput: function () {
            var $e = $(this.config.elem);
            var self = this;
            // 当绑定的元素带有value属性，并且对象未设置值时，设置一个初始值
            if (this.config.value === null && $e.attr('value')) {
                this.config.value = $e.attr('value');
            }
            var placeholder = this.config.placeholder;
            var fromIcon = this.icons.from;
            var downIcon = this.icons.down;
            var multiple = this.props.multiple;
            var extendClass = this.config.extendClass;
            var extendStyle = this.config.extendStyle;

            this.$div = $('<div class="el-cascader"></div>');
            if (extendStyle) {
                var style = $e.attr('style');
                if (style) {
                    this.$div.attr('style', style);
                }
            }
            if (extendClass) {
                var className = $e.attr('class');
                if (className) {
                    className.split(' ').forEach(function (name) {
                        self.$div.addClass(name);
                    });
                }
            }
            this.$input = $('<div class="el-input el-input--suffix">' +
                '<input type="text" readonly="readonly" autocomplete="off" placeholder="' + placeholder + '" class="el-input__inner">' +
                '<span class="el-input__suffix">' +
                '<span class="el-input__suffix-inner">' +
                '<i class="el-icon-arrow-down ' + fromIcon + ' ' + downIcon + '" style="font-size: 12px"></i>' +
                '</span></span>' +
                '</div>')
            this.$div.append(this.$input);
            this.$inputRow = this.$input.find('.el-input__inner');
            // 多选标签
            if (multiple) {
                this.$tags = $('<div class="el-cascader__tags"><!----></div>');
                this.$div.append(this.$tags);
            }
            this._initHideElement($e);
            // 替换元素
            $e.replaceWith(this.$div);
            this.$icon = this.$input.find('i');
            this._initFilterableInputEvent();
            this.disabled(this.config.disabled);
        },
        /**
         * 初始化隐藏元素input，主要用于layui的表单验证
         * @param $e
         * @private
         */
        _initHideElement: function ($e) {
            // 保存原始元素
            var attributes = $e[0].attributes;
            var $input = $('<input />');
            var keys = Object.keys(attributes);
            for (var key in keys) {
                var attribute = attributes[key];
                $input.attr(attribute.name, attribute.value);
            }
            $input.hide();
            $input.attr('type', 'hidden')
            this.$ec = $input;
            $e.before($input);
        },
        /**
         * 初始化可搜索监听事件
         * @private
         */
        _initFilterableInputEvent: function () {
            var filterable = this.config.filterable;
            if (!filterable) {
                return;
            }
            var timeoutID;
            var multiple = this.props.multiple;
            var debounce = this.config.debounce;
            var placeholder = this.config.placeholder;
            var beforeFilter = this.config.beforeFilter;
            var filterMethod = this.config.filterMethod;
            var checkStrictly = this.props.checkStrictly;
            var self = this;

            function filter(event) {
                var input = this;
                if (timeoutID) {
                    clearTimeout(timeoutID);
                }
                timeoutID = setTimeout(function () {
                    timeoutID = null;
                    var val = $(input).val();
                    if (!val) {
                        self.isFiltering = false;
                        return;
                    }
                    self.open();
                    if (typeof beforeFilter === 'function' && beforeFilter(val)) {
                        self.isFiltering = true;
                        var nodes = self.getNodes();
                        var filterNodes = nodes.filter(function (node) {
                            var disabled;
                            if (checkStrictly) {
                                disabled = node.disabled;
                            } else {
                                disabled = node.path.some(function (node) {
                                    return node.disabled;
                                });
                            }
                            if ((node.leaf || checkStrictly) && !disabled) {
                                if (typeof filterMethod === 'function' && filterMethod(node, val)) {
                                    // 命中
                                    return true;
                                }
                            }
                            return false;
                        });
                        self._setSuggestionMenu(filterNodes);
                    }
                }, debounce);
            }

            if (multiple) {
                // 多选可搜索
                this.$tagsInput = $('<input type="text" autocomplete="off" placeholder="' + placeholder + '" class="el-cascader__search-input">');
                var $tagsInput = this.$tagsInput;
                this.$tags.append($tagsInput);
                $tagsInput.on('keydown', filter);
                $tagsInput.click(function (event) {
                    if (self.isFiltering) {
                        event.stopPropagation();
                    }
                });
            } else {
                var $inputRow = this.$inputRow;
                // 单选可搜索
                $inputRow.removeAttr('readonly');
                $inputRow.on('keydown', filter);
                $inputRow.click(function (event) {
                    if (self.isFiltering) {
                        event.stopPropagation();
                    }
                });
            }
        },
        // 初始化面板(panel(1))
        _initPanel: function () {
            var $panel = this.$panel;
            var popperClass = this.config.popperClass || '';
            if (!$panel) {
                // z-index：解决和layer.open默认19891016的冲突
                this.$panel = $('<div class="el-popper el-cascader__dropdown ' + popperClass + '" style="position: absolute; z-index: 109891015;display: none;" x-placement="bottom-start"><div class="el-cascader-panel"></div><div class="popper__arrow" style="left: 35px;"></div></div>');
                $panel = this.$panel;
                $panel.appendTo('body');
                $panel.click(function (event) {
                    // 阻止事件冒泡
                    event.stopPropagation();
                });
                // 初始化可搜索面板
                this._initSuggestionPanel();
            }
        },
        /**
         * 添加菜单(panel(1)->menu(n))
         * @param nodes 当前层级数据
         * @param level 层级，从0开始
         * @param parentNode 父级节点
         * @param _menuItem 刷新时，传入的当前菜单的item数据
         * @private
         */
        _appendMenu: function (nodes, level, parentNode, _menuItem) {
            this._removeMenu(level);

            if (parentNode && parentNode.leaf) {
                return;
            }

            var menuData = this.data.menuData;
            var $div = $('<div class="el-scrollbar el-cascader-menu" role="menu" id="cascader-menu"><div class="el-cascader-menu__wrap el-scrollbar__wrap" style="margin-bottom: -17px; margin-right: -17px;"><ul class="el-scrollbar__view el-cascader-menu__list"></ul></div></div>');
            // 重新添加菜单
            this.$panel.find('.el-cascader-panel').append($div);
            // 渲染细项
            this._appendLi($div, nodes);
            var menuItem = {nodes: nodes, level: level, parentNode: parentNode, scrollbar: {top: 0, left: 0}};
            if (_menuItem) {
                menuItem.scrollbar = _menuItem.scrollbar
            }
            // 渲染滚动条
            this._initScrollbar($div, menuItem);
            // 重新定位面板
            this._resetXY();
            menuData.push(menuItem);
        },
        /**
         * 移除菜单
         * @param level
         * @private
         */
        _removeMenu: function (level) {
            // 除了上一层的所有菜单全部移除
            var number = level - 1;
            if (number !== -1) {
                this.$panel.find('.el-cascader-panel .el-cascader-menu:gt(' + number + ')').remove();
            } else {
                this.$panel.find('.el-cascader-panel .el-cascader-menu').remove();
            }
            // 保存菜单数据
            var menuData = this.data.menuData;
            if (menuData.length > level) {
                menuData.splice(level, menuData.length - level);
            }
        },
        /**
         * 添加细项(panel(1)->menu(n)->li(n))
         * @param $menu 当前菜单对象
         * @param nodes  当前层级数据
         * @private
         */
        _appendLi: function ($menu, nodes) {
            var $list = $menu.find('.el-cascader-menu__list');
            if (!nodes || nodes.length === 0) {
                var isEmpty = this.config.empty;
                $list.append('<div class="el-cascader-menu__empty-text">' + isEmpty + '</div>');
                return;
            }
            $.each(nodes, function (index, node) {
                node.bind($list);
            });
        },
        /**
         * 刷新菜单面板
         */
        refreshMenu: function () {
            // 先复制一个数组，避免刷新菜单时，数组的数据被改变
            var data = this.data.menuData.concat([]);
            var self = this;
            data.forEach(function (data) {
                self._appendMenu(data.nodes, data.level, data.parentNode, data);
            })
        },
        /**
         * 初始化可搜索面板
         * @private
         */
        _initSuggestionPanel: function () {
            var filterable = this.config.filterable;
            if (!filterable) {
                return;
            }
            var $suggestionPanel = this.$suggestionPanel;
            if (!$suggestionPanel) {
                this.$suggestionPanel = $('<div class="el-cascader__suggestion-panel el-scrollbar" style="display: none;"><div class="el-scrollbar__wrap" style="margin-bottom: -17px; margin-right: -17px;"><ul class="el-scrollbar__view el-cascader__suggestion-list" style="min-width: 222px;"></ul></div></div>');
                $suggestionPanel = this.$suggestionPanel;
                this.$panel.find('.popper__arrow').before($suggestionPanel);
                $suggestionPanel.click(function (event) {
                    // 阻止事件冒泡
                    event.stopPropagation();
                });
            }
        },
        /**
         * 设置可搜索菜单
         * @param nodes
         * @private
         */
        _setSuggestionMenu: function (nodes) {
            var $suggestionPanel = this.$suggestionPanel;
            var $list = $suggestionPanel.find('.el-cascader__suggestion-list');
            $list.empty();
            $suggestionPanel.find('.el-scrollbar__bar').remove();
            if (!nodes || nodes.length === 0) {
                $list.append('<li class="el-cascader__empty-text">无匹配数据</li>');
                return;
            }
            $.each(nodes, function (index, node) {
                node.bindSuggestion($list);
            });
            this._initScrollbar($suggestionPanel, {scrollbar: {top: 0, left: 0}});
            this._resetXY();
        },
        /**
         * 初始化节点数据
         * @param data 原始数据
         * @param level 层级
         * @param parentNode  父级节点
         * @returns {*[]}
         */
        initNodes: function (data, level, parentNode) {
            var nodes = [];
            for (var key in data) {
                var datum = data[key];
                var node = new Node(datum, this, level, parentNode);
                nodes.push(node);
                if (node.children && node.children.length > 0) {
                    node.setChildren(this.initNodes(node.children, level + 1, node));
                }
            }
            return nodes;
        },
        /**
         * 设置单选值
         * @param nodeId 节点id
         * @param node   节点对象
         * @private
         */
        _setActiveValue: function (nodeId, node) {
            if (this.data.activeNodeId !== nodeId) {
                var activeNode = this.data.activeNode;
                this.data.activeNodeId = nodeId;
                this.data.activeNode = node;
                activeNode && activeNode.transferParent(function (node) {
                    node.syncStyle();
                }, true);
                node && node.transferParent(function (node) {
                    node.syncStyle();
                }, true);
                // 填充路径
                this.change(node && node.value, node);
                if (nodeId !== null) {
                    this._setClear();
                }
            }
        },
        /**
         * 设置多选值
         * @param nodeIds 值数组
         * @param nodes 节点数组
         * @private
         */
        _setCheckedValue: function (nodeIds, nodes) {
            var checkedNodes = this.data.checkedNodes;
            var maxSize = this.config.maxSize;
            var maxSizeMode;
            if (nodeIds.length > 0 && maxSize !== 0 && nodeIds.length >= maxSize) {
                nodeIds = nodeIds.slice(0, maxSize);
                nodes = nodes.slice(0, maxSize);
                maxSizeMode = true
            } else {
                maxSizeMode = false
            }
            this.data.checkedNodeIds = nodeIds || [];
            this.data.checkedNodes = nodes || [];
            var syncPath = [];
            var syncNodeIds = [];
            checkedNodes.forEach(function (node) {
                node.path.forEach(function (node) {
                    if (syncNodeIds.indexOf(node.nodeId) === -1) {
                        syncPath.push(node);
                        syncNodeIds.push(node.nodeId);
                    }
                });
            });
            nodes.forEach(function (node) {
                node.path.forEach(function (node) {
                    if (syncNodeIds.indexOf(node.nodeId) === -1) {
                        syncPath.push(node);
                        syncNodeIds.push(node.nodeId);
                    }
                });
            });
            syncPath.forEach(function (node) {
                node.syncStyle();
            });
            // 填充路径
            this.change(nodes.map(function (node) {
                return node.value;
            }), nodes);
            this._setClear();
            this.maxSizeMode = maxSizeMode;
        },
        /**
         * 设置值
         * @param value
         */
        setValue: function (value) {
            if (this.data.activeNodeId || this.data.checkedNodeIds.length > 0) {
                // 清空值
                this.clearCheckedNodes();
            }
            if (!value) {
                return;
            }
            var strictMode = this.props.strictMode;
            if (strictMode) {
                if (!Array.isArray(value)) {
                    throw new Error("严格模式下,value必须是一个包含父子节点数组结构.");
                }
            }
            var nodes = this.getNodes(this.data.nodes);
            var checkStrictly = this.props.checkStrictly;
            var multiple = this.props.multiple;
            var disabledFixed = this.config.disabledFixed;
            if (multiple) {
                var paths = nodes.filter(function (node) {
                    if ((checkStrictly || node.leaf) && (!node.disabled || disabledFixed)) {
                        if (strictMode) {
                            // 严格模式下
                            // some:命中一个就为true
                            // every:全部命中为true
                            return value.some(function (levelValue) {
                                if (!Array.isArray(levelValue)) {
                                    throw new Error("多选严格模式下,value必须是一个二维数组结构.");
                                }
                                var path = node.path;
                                return levelValue.length === path.length && levelValue.every(function (rowValue, index) {
                                    return path[index].value === rowValue;
                                });
                            })
                        } else {
                            return value.indexOf(node.value) !== -1;
                        }
                    }
                    return false;
                });
                var nodeIds = paths.map(function (node) {
                    return node.nodeId;
                });
                this._setCheckedValue(nodeIds, paths);
                // 展开第一个节点
                if (paths.length > 0) {
                    var first = paths[0];
                    first.expandPanel();
                }
            } else {
                for (var i = 0; i < nodes.length; i++) {
                    var node = nodes[i];
                    if ((checkStrictly || node.leaf)) {
                        var is = false;
                        if (strictMode) {
                            // 严格模式下
                            // every:全部命中为true
                            var path = node.path;
                            is = value.length === path.length && value.every(function (rowValue, index) {
                                return path[index].value === rowValue;
                            });
                        } else if (node.value === value) {
                            is = true;
                        }
                        if (is) {
                            this._setActiveValue(node.nodeId, node);
                            // 展开节点
                            node.expandPanel();
                            break;
                        }
                    }
                }
            }
        },
        /**
         * 递归获取扁平的节点
         * @param nodes
         * @param container
         * @returns {*[]}
         */
        getNodes: function (nodes, container) {
            if (!container) {
                container = [];
            }
            if (!nodes) {
                nodes = this.data.nodes;
            }
            var self = this;
            nodes.forEach(function (node) {
                container.push(node);
                var children = node.getChildren();
                if (children) {
                    self.getNodes(children, container);
                }
            });
            return container;
        },
        /**
         * 初始化滚动条
         * @param $menu   菜单的dom节点对象
         * @param menuItem 当前菜单数据
         * @private
         */
        _initScrollbar: function ($menu, menuItem) {
            var $div = $('<div class="el-scrollbar__bar is-onhoriztal"><div class="el-scrollbar__thumb" style="transform: translateX(0%);"></div></div><div class="el-scrollbar__bar is-vertical"><div class="el-scrollbar__thumb" style="transform: translateY(0%);"></div></div>');
            $menu.append($div);
            var vertical = $($div[1]).find('.el-scrollbar__thumb');
            var onhoriztal = $($div[0]).find('.el-scrollbar__thumb');
            var scrollbar = $menu.find('.el-scrollbar__wrap');
            var $panel = this.$panel;
            var $lis = $menu.find('li');
            var height = Math.max($panel.height(), $menu.height());
            var hScale = (height - 6) / ($lis.height() * $lis.length);
            var wScale = $panel.width() / $lis.width();

            // 滚动条监听事件
            function _scrollbarEvent(scrollTop, scrollLeft) {
                if (hScale < 1) {
                    vertical.css('height', hScale * 100 + '%');
                    vertical.css('transform', 'translateY(' + scrollTop / $menu.height() * 100 + '%)');
                }
                if (wScale < 1) {
                    onhoriztal.css('width', wScale * 100 + '%');
                    onhoriztal.css('transform', 'translateY(' + scrollLeft / $menu.width() * 100 + '%)');
                }
            }

            // 拖动事件
            vertical.mousedown(function (event) {
                event.stopImmediatePropagation();
                event.stopPropagation();
                // 禁止文本选择事件
                var selectstart = function () {
                    return false;
                };
                $(document).bind("selectstart", selectstart);
                var y = event.clientY;
                var scrollTop = scrollbar.scrollTop();
                // 移动事件
                var mousemove = function (event) {
                    event.stopImmediatePropagation();
                    var number = scrollTop + (event.clientY - y) / hScale;
                    scrollbar.scrollTop(number);
                };
                $(document).bind('mousemove', mousemove);
                // 鼠标松开事件
                $(document).one('mouseup', function (event) {
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                    $(document).off('mousemove', mousemove);
                    $(document).off('selectstart', selectstart);
                });
            });
            // 监听滚动条事件
            scrollbar.scroll(function () {
                var scroll = $(this);
                menuItem.scrollbar.top = scroll.scrollTop()
                menuItem.scrollbar.left = scroll.scrollLeft()
                _scrollbarEvent(menuItem.scrollbar.top, menuItem.scrollbar.left);
            });

            // 初始化滚动条
            scrollbar.scrollTop(menuItem.scrollbar.top);
            _scrollbarEvent(menuItem.scrollbar.top, menuItem.scrollbar.left);
        },
        // 填充路径
        _fillingPath: function () {
            var multiple = this.props.multiple;
            var showAllLevels = this.config.showAllLevels;
            var separator = this.config.separator;
            var collapseTags = this.config.collapseTags;
            var $inputRow = this.$inputRow;
            var placeholder = this.config.placeholder;
            var self = this;
            if (!multiple) {
                var activeNode = this.data.activeNode;
                var path = activeNode && activeNode.path || [];
                if (showAllLevels) {
                    this._$inputRowSetValue(path.map(function (node) {
                        return node.label;
                    }).join(separator));
                } else {
                    this._$inputRowSetValue(activeNode && activeNode.label || "");
                }
            } else {
                // 复选框

                // 删除标签
                this.$tags.find('.el-tag').remove();
                var $tagsInput = this.$tagsInput;
                // 清除高度
                $inputRow.css('height', '');
                var checkedNodes = this.data.checkedNodes;
                var minCollapseTagsNumber = Math.max(this.config.minCollapseTagsNumber, 1);
                if (checkedNodes.length > 0) {
                    var tags = [];
                    var paths = checkedNodes;
                    if (collapseTags) {
                        // 折叠tags
                        paths = checkedNodes.slice(0, Math.min(checkedNodes.length, minCollapseTagsNumber));
                    }
                    paths.forEach(function (node) {
                        tags.push(node.$tag);
                    });
                    // 判断标签是否折叠
                    if (collapseTags) {
                        // 判断标签最小折叠数
                        if (checkedNodes.length > minCollapseTagsNumber) {
                            tags.push(self.get$tag('+ ' + (checkedNodes.length - minCollapseTagsNumber), false));
                        }
                    }
                    tags.forEach(function (tag) {
                        if ($tagsInput) {
                            $tagsInput.before(tag)
                        } else {
                            self.$tags.append(tag);
                        }
                    });
                }
                var tagHeight = self.$tags.height();
                var inputHeight = $inputRow.height();
                if (tagHeight > inputHeight) {
                    $inputRow.css('height', tagHeight + 4 + 'px');
                }
                // 重新定位
                this._resetXY();
                if (checkedNodes.length > 0) {
                    $inputRow.removeAttr('placeholder');
                    $tagsInput && $tagsInput.removeAttr('placeholder', placeholder);
                } else {
                    $inputRow.attr('placeholder', placeholder);
                    $tagsInput && $tagsInput.attr('placeholder', placeholder);
                }
            }
        },
        /**
         * 设置单选输入框的值
         * @param label
         * @private
         */
        _$inputRowSetValue: function (label) {
            label = label || "";
            var $inputRow = this.$inputRow;
            $inputRow.attr('value', label); //防止被重置
            $inputRow.val(label);
        },
        /**
         * 获取复选框标签对象
         * @param label
         * @param showCloseIcon 是否显示关闭的icon
         * @returns {jQuery|HTMLElement|*}
         */
        get$tag: function (label, showCloseIcon) {
            var fromIcon = this.icons.from;
            var closeIcon = this.icons.close;
            var icon = showCloseIcon ? '<i class="el-tag__close el-icon-close ' + fromIcon + ' ' + closeIcon + '"></i>' : '';
            return $('<span class="el-tag el-tag--info el-tag--small el-tag--light"><span>' + label + '</span>' + icon + '</span>');
        },
        // 设置可清理
        _setClear: function () {
            var self = this;

            function enter() {
                self.$icon.removeClass(self.icons.down);
                self.$icon.addClass(self.icons.close);
            }

            function out() {
                self.$icon.removeClass(self.icons.close);
                self.$icon.addClass(self.icons.down);
            }

            self.$div.mouseenter(function () {
                enter();
            });
            self.$div.mouseleave(function () {
                out();
            });
            self.$icon.off('click');
            var multiple = this.props.multiple;
            var clear;
            if (multiple) {
                clear = this.data.checkedNodeIds.length > 0;
            } else {
                clear = !!this.data.activeNodeId;
            }
            if (clear && !this.config.disabled && this.config.clearable) {
                self.$icon.one('click', function (event) {
                    event.stopPropagation();
                    self.close();
                    self.clearCheckedNodes();
                    out();
                    self.$icon.off('mouseenter');
                    self.$div.off('mouseenter');
                    self.$div.off('mouseleave');
                });
            } else {
                out();
                self.$icon.off('mouseenter');
                self.$div.off('mouseenter');
                self.$div.off('mouseleave');
            }
        },
        // 禁用
        disabled: function (isDisabled) {
            this.config.disabled = !!isDisabled;
            if (this.config.disabled) {
                this.$div.addClass('is-disabled');
                this.$div.find('.el-input--suffix').addClass('is-disabled');
                this.$inputRow.attr('disabled', 'disabled');
                this.$tagsInput && this.$tagsInput.attr('disabled', 'disabled').hide()
            } else {
                this.$div.removeClass('is-disabled');
                this.$div.find('.el-input--suffix').removeClass('is-disabled');
                this.$inputRow.removeAttr('disabled');
                this.$tagsInput && this.$tagsInput.removeAttr('disabled').show();
            }
            // 重新设置是否可被清理
            this._setClear();
            // 重新填充路径
            this._fillingPath();
        },
        /**
         * 当选中节点变化时触发  选中节点的值
         * @param value 值
         * @param node  节点
         */
        change: function (value, node) {
            var multiple = this.props.multiple;
            if (multiple) {
                if (value && value.length > 0) {
                    this.$ec.attr('value', JSON.stringify(value));
                    // this.$ec.val(JSON.stringify(value));
                } else {
                    this.$ec.removeAttr('value');
                    // this.$ec.val('');
                }
            } else {
                this.$ec.attr('value', value || "");
                // this.$ec.val(value);
            }
            // 填充路径
            this._fillingPath();
            this.event.change.forEach(function (e) {
                typeof e === 'function' && e(value, node)
            })
        },
        /**
         * 当失去焦点时触发  (event: Event)
         * @param eventId 不为空时，必须与closeEventId值相等，防止旧事件触发
         */
        close: function (eventId) {
            if (this.showPanel && (!eventId || this.closeEventId === eventId)) {
                this.showPanel = false;
                this.$div.find('.layui-icon-down').removeClass('is-reverse');
                this.$panel.slideUp(100);
                this.visibleChange(false);
                // 聚焦颜色
                this.$input.removeClass('is-focus');
                // 可搜索
                var filterable = this.config.filterable;
                if (filterable) {
                    this.isFiltering = false;
                    this._fillingPath();
                }
                this.event.close.forEach(function (e) {
                    typeof e === 'function' && e()
                })
            }
        },
        /**
         * 当获得焦点时触发  (event: Event)
         */
        open: function () {
            if (!this.showPanel) {
                this.showPanel = true;
                this.closeEventId++;
                var self = this;
                // 当前传播事件结束后，添加点击背景关闭面板事件
                setTimeout(function () {
                    $(document).one('click', self.close.bind(self, self.closeEventId));
                });
                // 重新定位面板
                this._resetXY();
                // 箭头icon翻转
                this.$div.find('.layui-icon-down').addClass('is-reverse');
                this.$panel.slideDown(200);
                this.visibleChange(true);
                // 聚焦颜色
                this.$input.addClass('is-focus');
                this.event.open.forEach(function (e) {
                    typeof e === 'function' && e()
                })
            }
        },
        /**
         * 下拉框出现/隐藏时触发
         * @param visible 出现则为 true，隐藏则为 false
         */
        visibleChange: function (visible) {
        },
        /**
         * 在多选模式下，移除Tag时触发  移除的Tag对应的节点的值
         * @param tagValue 节点的值
         * @param node 节点对象
         */
        removeTag: function (tagValue, node) {
        },
        /**
         * 获取选中的节点值
         * @returns {null|[]}
         */
        getCheckedValues: function () {
            var strictMode = this.props.strictMode;
            if (this.props.multiple) {
                var checkedNodes = this.data.checkedNodes;
                if (strictMode) {
                    return checkedNodes.map(function (node) {
                        return node.path.map(function (node1) {
                            return node1.value;
                        });
                    });
                }
                return checkedNodes.map(function (node) {
                    return node.value;
                });
            } else {
                var activeNode = this.data.activeNode;
                if (strictMode) {
                    return activeNode && activeNode.path.map(function (node) {
                        return node.value;
                    })
                }
                return activeNode && activeNode.value;
            }
        },
        /**
         * 获取选中的节点
         * @returns {null|[]}
         */
        getCheckedNodes: function () {
            var strictMode = this.props.strictMode;
            if (this.props.multiple) {
                var checkedNodes = this.data.checkedNodes;
                if (strictMode) {
                    return checkedNodes && checkedNodes.map(function (node) {
                        return node.path;
                    });
                }
                return checkedNodes;
            } else {
                var activeNode = this.data.activeNode;
                if (strictMode) {
                    return activeNode && activeNode.path;
                }
                return activeNode;
            }
        },
        /**
         * 清空选中的节点
         * @param force 强制清理禁用固定节点
         */
        clearCheckedNodes: function (force) {
            var multiple = this.props.multiple;
            if (multiple) {
                var disabledFixed = this.config.disabledFixed;
                if (!force && disabledFixed) {
                    //禁用项被固定，则过滤出禁用项的选值出来
                    var checkedNodes = this.data.checkedNodes;
                    var disNodes = checkedNodes.filter(function (node) {
                        return node.disabled;
                    });
                    var nodeIds = disNodes.map(function (node) {
                        return node.nodeId;
                    });
                    this._setCheckedValue(nodeIds, disNodes);
                } else {
                    this._setCheckedValue([], []);
                }
            } else {
                this._setActiveValue(null, null);
            }
        }
    };

    var thisCas = function () {
        var self = this;
        return {
            /**
             * 设置选项值
             * @param options
             */
            setOptions: function (options) {
                self.setOptions(options);
            },
            /**
             * 覆盖当前值
             * @param value 单选时传对象，多选时传数组
             */
            setValue: function (value) {
                self.setValue(value);
            },
            /**
             * 当节点变更时，执行回调
             * @param callback  function(value,node){}
             */
            changeEvent: function (callback) {
                self.event.change.push(callback);
            },
            /**
             * 当面板关闭时，执行回调
             * @param callback  function(){}
             */
            closeEvent: function (callback) {
                self.event.close.push(callback);
            },
            /**
             * 当面板打开时，执行回调
             * @param callback  function(){}
             */
            openEvent: function (callback) {
                self.event.open.push(callback);
            },
            /**
             * 禁用组件
             * @param disabled true/false
             */
            disabled: function (disabled) {
                self.disabled(disabled);
            },
            /**
             * 收起面板
             */
            close: function () {
                self.close();
            },
            /**
             * 展开面板
             */
            open: function () {
                self.open();
            },
            /**
             * 获取选中的节点，如需获取路径，使用node.path获取,将获取各级节点的node对象
             * @returns {[]|*}
             */
            getCheckedNodes: function () {
                return self.getCheckedNodes();
            },
            /**
             * 获取选中的值
             * @returns {[]|*}
             */
            getCheckedValues: function () {
                return self.getCheckedValues();
            },
            /**
             * 清空选中的节点
             * @param force 强制清理禁用固定节点
             */
            clearCheckedNodes: function (force) {
                self.clearCheckedNodes(force);
            },
            /**
             * 展开面板到节点所在的层级
             * @param value 节点值，只能传单个值，不允许传数组
             */
            expandNode: function (value) {
                var nodes = self.getNodes(self.data.nodes);
                for (var i = 0; i < nodes.length; i++) {
                    var node = nodes[i];
                    if (node.value === value) {
                        node.expandPanel();
                        break;
                    }
                }
            },
            /**
             * 获取当前配置副本
             */
            getConfig: function () {
                return $.extend(true, {}, self.config);
            },
            /**
             * 获取数据对象副本
             * @returns {*}
             */
            getData: function () {
                return $.extend(true, {}, self.data);
            }
        };
    };

    exports('layCascader', function (option) {
        var ins = new Cascader(option);
        return thisCas.call(ins);
    });
});
