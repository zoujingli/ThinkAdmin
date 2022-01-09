(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('vue')) :
  typeof define === 'function' && define.amd ? define(['exports', 'vue'], factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.ElementPlusIconsVue = {}, global.Vue));
})(this, (function (exports, vue) { 'use strict';

  var _export_sfc = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
      target[key] = val;
    }
    return target;
  };

  const _sfc_main$4n = vue.defineComponent({
    name: "AddLocation"
  });
  const _hoisted_1$4n = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4n = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 896h448q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_3$4m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M800 416a288 288 0 10-576 0c0 118.144 94.528 272.128 288 456.576C705.472 688.128 800 534.144 800 416zM512 960C277.312 746.688 160 565.312 160 416a352 352 0 01704 0c0 149.312-117.312 330.688-352 544z"
  }, null, -1);
  const _hoisted_4$1f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 384h96a32 32 0 110 64h-96v96a32 32 0 01-64 0v-96h-96a32 32 0 010-64h96v-96a32 32 0 0164 0v96z"
  }, null, -1);
  const _hoisted_5$k = [
    _hoisted_2$4n,
    _hoisted_3$4m,
    _hoisted_4$1f
  ];
  function _sfc_render$4n(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4n, _hoisted_5$k);
  }
  var addLocation = /* @__PURE__ */ _export_sfc(_sfc_main$4n, [["render", _sfc_render$4n]]);

  const _sfc_main$4m = vue.defineComponent({
    name: "Aim"
  });
  const _hoisted_1$4m = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$4l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 96a32 32 0 0132 32v192a32 32 0 01-64 0V128a32 32 0 0132-32zm0 576a32 32 0 0132 32v192a32 32 0 11-64 0V704a32 32 0 0132-32zM96 512a32 32 0 0132-32h192a32 32 0 010 64H128a32 32 0 01-32-32zm576 0a32 32 0 0132-32h192a32 32 0 110 64H704a32 32 0 01-32-32z"
  }, null, -1);
  const _hoisted_4$1e = [
    _hoisted_2$4m,
    _hoisted_3$4l
  ];
  function _sfc_render$4m(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4m, _hoisted_4$1e);
  }
  var aim = /* @__PURE__ */ _export_sfc(_sfc_main$4m, [["render", _sfc_render$4m]]);

  const _sfc_main$4l = vue.defineComponent({
    name: "AlarmClock"
  });
  const _hoisted_1$4l = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 832a320 320 0 100-640 320 320 0 000 640zm0 64a384 384 0 110-768 384 384 0 010 768z"
  }, null, -1);
  const _hoisted_3$4k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M292.288 824.576l55.424 32-48 83.136a32 32 0 11-55.424-32l48-83.136zm439.424 0l-55.424 32 48 83.136a32 32 0 1055.424-32l-48-83.136zM512 512h160a32 32 0 110 64H480a32 32 0 01-32-32V320a32 32 0 0164 0v192zM90.496 312.256A160 160 0 01312.32 90.496l-46.848 46.848a96 96 0 00-128 128L90.56 312.256zm835.264 0A160 160 0 00704 90.496l46.848 46.848a96 96 0 01128 128l46.912 46.912z"
  }, null, -1);
  const _hoisted_4$1d = [
    _hoisted_2$4l,
    _hoisted_3$4k
  ];
  function _sfc_render$4l(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4l, _hoisted_4$1d);
  }
  var alarmClock = /* @__PURE__ */ _export_sfc(_sfc_main$4l, [["render", _sfc_render$4l]]);

  const _sfc_main$4k = vue.defineComponent({
    name: "Apple"
  });
  const _hoisted_1$4k = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M599.872 203.776a189.44 189.44 0 0164.384-4.672l2.624.128c31.168 1.024 51.2 4.096 79.488 16.32 37.632 16.128 74.496 45.056 111.488 89.344 96.384 115.264 82.752 372.8-34.752 521.728-7.68 9.728-32 41.6-30.72 39.936a426.624 426.624 0 01-30.08 35.776c-31.232 32.576-65.28 49.216-110.08 50.048-31.36.64-53.568-5.312-84.288-18.752l-6.528-2.88c-20.992-9.216-30.592-11.904-47.296-11.904-18.112 0-28.608 2.88-51.136 12.672l-6.464 2.816c-28.416 12.224-48.32 18.048-76.16 19.2-74.112 2.752-116.928-38.08-180.672-132.16-96.64-142.08-132.608-349.312-55.04-486.4 46.272-81.92 129.92-133.632 220.672-135.04 32.832-.576 60.288 6.848 99.648 22.72 27.136 10.88 34.752 13.76 37.376 14.272 16.256-20.16 27.776-36.992 34.56-50.24 13.568-26.304 27.2-59.968 40.704-100.8a32 32 0 1160.8 20.224c-12.608 37.888-25.408 70.4-38.528 97.664zm-51.52 78.08c-14.528 17.792-31.808 37.376-51.904 58.816a32 32 0 11-46.72-43.776l12.288-13.248c-28.032-11.2-61.248-26.688-95.68-26.112-70.4 1.088-135.296 41.6-171.648 105.792C121.6 492.608 176 684.16 247.296 788.992c34.816 51.328 76.352 108.992 130.944 106.944 52.48-2.112 72.32-34.688 135.872-34.688 63.552 0 81.28 34.688 136.96 33.536 56.448-1.088 75.776-39.04 126.848-103.872 107.904-136.768 107.904-362.752 35.776-449.088-72.192-86.272-124.672-84.096-151.68-85.12-41.472-4.288-81.6 12.544-113.664 25.152z"
  }, null, -1);
  const _hoisted_3$4j = [
    _hoisted_2$4k
  ];
  function _sfc_render$4k(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4k, _hoisted_3$4j);
  }
  var apple = /* @__PURE__ */ _export_sfc(_sfc_main$4k, [["render", _sfc_render$4k]]);

  const _sfc_main$4j = vue.defineComponent({
    name: "ArrowDownBold"
  });
  const _hoisted_1$4j = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M104.704 338.752a64 64 0 0190.496 0l316.8 316.8 316.8-316.8a64 64 0 0190.496 90.496L557.248 791.296a64 64 0 01-90.496 0L104.704 429.248a64 64 0 010-90.496z"
  }, null, -1);
  const _hoisted_3$4i = [
    _hoisted_2$4j
  ];
  function _sfc_render$4j(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4j, _hoisted_3$4i);
  }
  var arrowDownBold = /* @__PURE__ */ _export_sfc(_sfc_main$4j, [["render", _sfc_render$4j]]);

  const _sfc_main$4i = vue.defineComponent({
    name: "ArrowDown"
  });
  const _hoisted_1$4i = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4i = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M831.872 340.864L512 652.672 192.128 340.864a30.592 30.592 0 00-42.752 0 29.12 29.12 0 000 41.6L489.664 714.24a32 32 0 0044.672 0l340.288-331.712a29.12 29.12 0 000-41.728 30.592 30.592 0 00-42.752 0z"
  }, null, -1);
  const _hoisted_3$4h = [
    _hoisted_2$4i
  ];
  function _sfc_render$4i(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4i, _hoisted_3$4h);
  }
  var arrowDown = /* @__PURE__ */ _export_sfc(_sfc_main$4i, [["render", _sfc_render$4i]]);

  const _sfc_main$4h = vue.defineComponent({
    name: "ArrowLeftBold"
  });
  const _hoisted_1$4h = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4h = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M685.248 104.704a64 64 0 010 90.496L368.448 512l316.8 316.8a64 64 0 01-90.496 90.496L232.704 557.248a64 64 0 010-90.496l362.048-362.048a64 64 0 0190.496 0z"
  }, null, -1);
  const _hoisted_3$4g = [
    _hoisted_2$4h
  ];
  function _sfc_render$4h(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4h, _hoisted_3$4g);
  }
  var arrowLeftBold = /* @__PURE__ */ _export_sfc(_sfc_main$4h, [["render", _sfc_render$4h]]);

  const _sfc_main$4g = vue.defineComponent({
    name: "ArrowLeft"
  });
  const _hoisted_1$4g = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4g = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M609.408 149.376L277.76 489.6a32 32 0 000 44.672l331.648 340.352a29.12 29.12 0 0041.728 0 30.592 30.592 0 000-42.752L339.264 511.936l311.872-319.872a30.592 30.592 0 000-42.688 29.12 29.12 0 00-41.728 0z"
  }, null, -1);
  const _hoisted_3$4f = [
    _hoisted_2$4g
  ];
  function _sfc_render$4g(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4g, _hoisted_3$4f);
  }
  var arrowLeft = /* @__PURE__ */ _export_sfc(_sfc_main$4g, [["render", _sfc_render$4g]]);

  const _sfc_main$4f = vue.defineComponent({
    name: "ArrowRightBold"
  });
  const _hoisted_1$4f = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M338.752 104.704a64 64 0 000 90.496l316.8 316.8-316.8 316.8a64 64 0 0090.496 90.496l362.048-362.048a64 64 0 000-90.496L429.248 104.704a64 64 0 00-90.496 0z"
  }, null, -1);
  const _hoisted_3$4e = [
    _hoisted_2$4f
  ];
  function _sfc_render$4f(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4f, _hoisted_3$4e);
  }
  var arrowRightBold = /* @__PURE__ */ _export_sfc(_sfc_main$4f, [["render", _sfc_render$4f]]);

  const _sfc_main$4e = vue.defineComponent({
    name: "ArrowRight"
  });
  const _hoisted_1$4e = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4e = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M340.864 149.312a30.592 30.592 0 000 42.752L652.736 512 340.864 831.872a30.592 30.592 0 000 42.752 29.12 29.12 0 0041.728 0L714.24 534.336a32 32 0 000-44.672L382.592 149.376a29.12 29.12 0 00-41.728 0z"
  }, null, -1);
  const _hoisted_3$4d = [
    _hoisted_2$4e
  ];
  function _sfc_render$4e(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4e, _hoisted_3$4d);
  }
  var arrowRight = /* @__PURE__ */ _export_sfc(_sfc_main$4e, [["render", _sfc_render$4e]]);

  const _sfc_main$4d = vue.defineComponent({
    name: "ArrowUpBold"
  });
  const _hoisted_1$4d = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4d = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M104.704 685.248a64 64 0 0090.496 0l316.8-316.8 316.8 316.8a64 64 0 0090.496-90.496L557.248 232.704a64 64 0 00-90.496 0L104.704 594.752a64 64 0 000 90.496z"
  }, null, -1);
  const _hoisted_3$4c = [
    _hoisted_2$4d
  ];
  function _sfc_render$4d(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4d, _hoisted_3$4c);
  }
  var arrowUpBold = /* @__PURE__ */ _export_sfc(_sfc_main$4d, [["render", _sfc_render$4d]]);

  const _sfc_main$4c = vue.defineComponent({
    name: "ArrowUp"
  });
  const _hoisted_1$4c = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4c = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M488.832 344.32l-339.84 356.672a32 32 0 000 44.16l.384.384a29.44 29.44 0 0042.688 0l320-335.872 319.872 335.872a29.44 29.44 0 0042.688 0l.384-.384a32 32 0 000-44.16L535.168 344.32a32 32 0 00-46.336 0z"
  }, null, -1);
  const _hoisted_3$4b = [
    _hoisted_2$4c
  ];
  function _sfc_render$4c(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4c, _hoisted_3$4b);
  }
  var arrowUp = /* @__PURE__ */ _export_sfc(_sfc_main$4c, [["render", _sfc_render$4c]]);

  const _sfc_main$4b = vue.defineComponent({
    name: "Avatar"
  });
  const _hoisted_1$4b = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M628.736 528.896A416 416 0 01928 928H96a415.872 415.872 0 01299.264-399.104L512 704l116.736-175.104zM720 304a208 208 0 11-416 0 208 208 0 01416 0z"
  }, null, -1);
  const _hoisted_3$4a = [
    _hoisted_2$4b
  ];
  function _sfc_render$4b(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4b, _hoisted_3$4a);
  }
  var avatar = /* @__PURE__ */ _export_sfc(_sfc_main$4b, [["render", _sfc_render$4b]]);

  const _sfc_main$4a = vue.defineComponent({
    name: "Back"
  });
  const _hoisted_1$4a = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 480h640a32 32 0 110 64H224a32 32 0 010-64z"
  }, null, -1);
  const _hoisted_3$49 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M237.248 512l265.408 265.344a32 32 0 01-45.312 45.312l-288-288a32 32 0 010-45.312l288-288a32 32 0 1145.312 45.312L237.248 512z"
  }, null, -1);
  const _hoisted_4$1c = [
    _hoisted_2$4a,
    _hoisted_3$49
  ];
  function _sfc_render$4a(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4a, _hoisted_4$1c);
  }
  var back = /* @__PURE__ */ _export_sfc(_sfc_main$4a, [["render", _sfc_render$4a]]);

  const _sfc_main$49 = vue.defineComponent({
    name: "Baseball"
  });
  const _hoisted_1$49 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$49 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M195.2 828.8a448 448 0 11633.6-633.6 448 448 0 01-633.6 633.6zm45.248-45.248a384 384 0 10543.104-543.104 384 384 0 00-543.104 543.104z"
  }, null, -1);
  const _hoisted_3$48 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M497.472 96.896c22.784 4.672 44.416 9.472 64.896 14.528a256.128 256.128 0 00350.208 350.208c5.056 20.48 9.856 42.112 14.528 64.896A320.128 320.128 0 01497.472 96.896zM108.48 491.904a320.128 320.128 0 01423.616 423.68c-23.04-3.648-44.992-7.424-65.728-11.52a256.128 256.128 0 00-346.496-346.432 1736.64 1736.64 0 01-11.392-65.728z"
  }, null, -1);
  const _hoisted_4$1b = [
    _hoisted_2$49,
    _hoisted_3$48
  ];
  function _sfc_render$49(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$49, _hoisted_4$1b);
  }
  var baseball = /* @__PURE__ */ _export_sfc(_sfc_main$49, [["render", _sfc_render$49]]);

  const _sfc_main$48 = vue.defineComponent({
    name: "Basketball"
  });
  const _hoisted_1$48 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$48 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M778.752 788.224a382.464 382.464 0 00116.032-245.632 256.512 256.512 0 00-241.728-13.952 762.88 762.88 0 01125.696 259.584zm-55.04 44.224a699.648 699.648 0 00-125.056-269.632 256.128 256.128 0 00-56.064 331.968 382.72 382.72 0 00181.12-62.336zm-254.08 61.248A320.128 320.128 0 01557.76 513.6a715.84 715.84 0 00-48.192-48.128 320.128 320.128 0 01-379.264 88.384 382.4 382.4 0 00110.144 229.696 382.4 382.4 0 00229.184 110.08zM129.28 481.088a256.128 256.128 0 00331.072-56.448 699.648 699.648 0 00-268.8-124.352 382.656 382.656 0 00-62.272 180.8zm106.56-235.84a762.88 762.88 0 01258.688 125.056 256.512 256.512 0 00-13.44-241.088A382.464 382.464 0 00235.84 245.248zm318.08-114.944c40.576 89.536 37.76 193.92-8.448 281.344a779.84 779.84 0 0166.176 66.112 320.832 320.832 0 01282.112-8.128 382.4 382.4 0 00-110.144-229.12 382.4 382.4 0 00-229.632-110.208zM828.8 828.8a448 448 0 11-633.6-633.6 448 448 0 01633.6 633.6z"
  }, null, -1);
  const _hoisted_3$47 = [
    _hoisted_2$48
  ];
  function _sfc_render$48(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$48, _hoisted_3$47);
  }
  var basketball = /* @__PURE__ */ _export_sfc(_sfc_main$48, [["render", _sfc_render$48]]);

  const _sfc_main$47 = vue.defineComponent({
    name: "BellFilled"
  });
  const _hoisted_1$47 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$47 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 832a128 128 0 01-256 0h256zm192-64H134.4a38.4 38.4 0 010-76.8H192V448c0-154.88 110.08-284.16 256.32-313.6a64 64 0 11127.36 0A320.128 320.128 0 01832 448v243.2h57.6a38.4 38.4 0 010 76.8H832z"
  }, null, -1);
  const _hoisted_3$46 = [
    _hoisted_2$47
  ];
  function _sfc_render$47(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$47, _hoisted_3$46);
  }
  var bellFilled = /* @__PURE__ */ _export_sfc(_sfc_main$47, [["render", _sfc_render$47]]);

  const _sfc_main$46 = vue.defineComponent({
    name: "Bell"
  });
  const _hoisted_1$46 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$46 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a64 64 0 0164 64v64H448v-64a64 64 0 0164-64z"
  }, null, -1);
  const _hoisted_3$45 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 768h512V448a256 256 0 10-512 0v320zm256-640a320 320 0 01320 320v384H192V448a320 320 0 01320-320z"
  }, null, -1);
  const _hoisted_4$1a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M96 768h832q32 0 32 32t-32 32H96q-32 0-32-32t32-32zM448 896h128a64 64 0 01-128 0z"
  }, null, -1);
  const _hoisted_5$j = [
    _hoisted_2$46,
    _hoisted_3$45,
    _hoisted_4$1a
  ];
  function _sfc_render$46(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$46, _hoisted_5$j);
  }
  var bell = /* @__PURE__ */ _export_sfc(_sfc_main$46, [["render", _sfc_render$46]]);

  const _sfc_main$45 = vue.defineComponent({
    name: "Bicycle"
  });
  const _hoisted_1$45 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$45 = /* @__PURE__ */ vue.createStaticVNode('<path fill="currentColor" d="M256 832a128 128 0 100-256 128 128 0 000 256zm0 64a192 192 0 110-384 192 192 0 010 384z"></path><path fill="currentColor" d="M288 672h320q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"></path><path fill="currentColor" d="M768 832a128 128 0 100-256 128 128 0 000 256zm0 64a192 192 0 110-384 192 192 0 010 384z"></path><path fill="currentColor" d="M480 192a32 32 0 010-64h160a32 32 0 0131.04 24.256l96 384a32 32 0 01-62.08 15.488L615.04 192H480zM96 384a32 32 0 010-64h128a32 32 0 0130.336 21.888l64 192a32 32 0 11-60.672 20.224L200.96 384H96z"></path><path fill="currentColor" d="M373.376 599.808l-42.752-47.616 320-288 42.752 47.616z"></path>', 5);
  const _hoisted_7 = [
    _hoisted_2$45
  ];
  function _sfc_render$45(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$45, _hoisted_7);
  }
  var bicycle = /* @__PURE__ */ _export_sfc(_sfc_main$45, [["render", _sfc_render$45]]);

  const _sfc_main$44 = vue.defineComponent({
    name: "BottomLeft"
  });
  const _hoisted_1$44 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$44 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 768h416a32 32 0 110 64H224a32 32 0 01-32-32V352a32 32 0 0164 0v416z"
  }, null, -1);
  const _hoisted_3$44 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M246.656 822.656a32 32 0 01-45.312-45.312l544-544a32 32 0 0145.312 45.312l-544 544z"
  }, null, -1);
  const _hoisted_4$19 = [
    _hoisted_2$44,
    _hoisted_3$44
  ];
  function _sfc_render$44(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$44, _hoisted_4$19);
  }
  var bottomLeft = /* @__PURE__ */ _export_sfc(_sfc_main$44, [["render", _sfc_render$44]]);

  const _sfc_main$43 = vue.defineComponent({
    name: "BottomRight"
  });
  const _hoisted_1$43 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$43 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 768a32 32 0 100 64h448a32 32 0 0032-32V352a32 32 0 00-64 0v416H352z"
  }, null, -1);
  const _hoisted_3$43 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M777.344 822.656a32 32 0 0045.312-45.312l-544-544a32 32 0 00-45.312 45.312l544 544z"
  }, null, -1);
  const _hoisted_4$18 = [
    _hoisted_2$43,
    _hoisted_3$43
  ];
  function _sfc_render$43(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$43, _hoisted_4$18);
  }
  var bottomRight = /* @__PURE__ */ _export_sfc(_sfc_main$43, [["render", _sfc_render$43]]);

  const _sfc_main$42 = vue.defineComponent({
    name: "Bottom"
  });
  const _hoisted_1$42 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$42 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 805.888V168a32 32 0 10-64 0v637.888L246.656 557.952a30.72 30.72 0 00-45.312 0 35.52 35.52 0 000 48.064l288 306.048a30.72 30.72 0 0045.312 0l288-306.048a35.52 35.52 0 000-48 30.72 30.72 0 00-45.312 0L544 805.824z"
  }, null, -1);
  const _hoisted_3$42 = [
    _hoisted_2$42
  ];
  function _sfc_render$42(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$42, _hoisted_3$42);
  }
  var bottom = /* @__PURE__ */ _export_sfc(_sfc_main$42, [["render", _sfc_render$42]]);

  const _sfc_main$41 = vue.defineComponent({
    name: "Bowl"
  });
  const _hoisted_1$41 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$41 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M714.432 704a351.744 351.744 0 00148.16-256H161.408a351.744 351.744 0 00148.16 256h404.864zM288 766.592A415.68 415.68 0 0196 416a32 32 0 0132-32h768a32 32 0 0132 32 415.68 415.68 0 01-192 350.592V832a64 64 0 01-64 64H352a64 64 0 01-64-64v-65.408zM493.248 320h-90.496l254.4-254.4a32 32 0 1145.248 45.248L493.248 320zm187.328 0h-128l269.696-155.712a32 32 0 0132 55.424L680.576 320zM352 768v64h320v-64H352z"
  }, null, -1);
  const _hoisted_3$41 = [
    _hoisted_2$41
  ];
  function _sfc_render$41(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$41, _hoisted_3$41);
  }
  var bowl = /* @__PURE__ */ _export_sfc(_sfc_main$41, [["render", _sfc_render$41]]);

  const _sfc_main$40 = vue.defineComponent({
    name: "Box"
  });
  const _hoisted_1$40 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$40 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M317.056 128L128 344.064V896h768V344.064L706.944 128H317.056zm-14.528-64h418.944a32 32 0 0124.064 10.88l206.528 236.096A32 32 0 01960 332.032V928a32 32 0 01-32 32H96a32 32 0 01-32-32V332.032a32 32 0 017.936-21.12L278.4 75.008A32 32 0 01302.528 64z"
  }, null, -1);
  const _hoisted_3$40 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M64 320h896v64H64z"
  }, null, -1);
  const _hoisted_4$17 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M448 327.872V640h128V327.872L526.08 128h-28.16L448 327.872zM448 64h128l64 256v352a32 32 0 01-32 32H416a32 32 0 01-32-32V320l64-256z"
  }, null, -1);
  const _hoisted_5$i = [
    _hoisted_2$40,
    _hoisted_3$40,
    _hoisted_4$17
  ];
  function _sfc_render$40(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$40, _hoisted_5$i);
  }
  var box = /* @__PURE__ */ _export_sfc(_sfc_main$40, [["render", _sfc_render$40]]);

  const _sfc_main$3$ = vue.defineComponent({
    name: "Briefcase"
  });
  const _hoisted_1$3$ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3$ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M320 320V128h384v192h192v192H128V320h192zM128 576h768v320H128V576zm256-256h256.064V192H384v128z"
  }, null, -1);
  const _hoisted_3$3$ = [
    _hoisted_2$3$
  ];
  function _sfc_render$3$(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3$, _hoisted_3$3$);
  }
  var briefcase = /* @__PURE__ */ _export_sfc(_sfc_main$3$, [["render", _sfc_render$3$]]);

  const _sfc_main$3_ = vue.defineComponent({
    name: "BrushFilled"
  });
  const _hoisted_1$3_ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3_ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M608 704v160a96 96 0 01-192 0V704h-96a128 128 0 01-128-128h640a128 128 0 01-128 128h-96zM192 512V128.064h640V512H192z"
  }, null, -1);
  const _hoisted_3$3_ = [
    _hoisted_2$3_
  ];
  function _sfc_render$3_(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3_, _hoisted_3$3_);
  }
  var brushFilled = /* @__PURE__ */ _export_sfc(_sfc_main$3_, [["render", _sfc_render$3_]]);

  const _sfc_main$3Z = vue.defineComponent({
    name: "Brush"
  });
  const _hoisted_1$3Z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3Z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M896 448H128v192a64 64 0 0064 64h192v192h256V704h192a64 64 0 0064-64V448zm-770.752-64c0-47.552 5.248-90.24 15.552-128 14.72-54.016 42.496-107.392 83.2-160h417.28l-15.36 70.336L736 96h211.2c-24.832 42.88-41.92 96.256-51.2 160a663.872 663.872 0 00-6.144 128H960v256a128 128 0 01-128 128H704v160a32 32 0 01-32 32H352a32 32 0 01-32-32V768H192A128 128 0 0164 640V384h61.248zm64 0h636.544c-2.048-45.824.256-91.584 6.848-137.216 4.48-30.848 10.688-59.776 18.688-86.784h-96.64l-221.12 141.248L561.92 160H256.512c-25.856 37.888-43.776 75.456-53.952 112.832-8.768 32.064-13.248 69.12-13.312 111.168z"
  }, null, -1);
  const _hoisted_3$3Z = [
    _hoisted_2$3Z
  ];
  function _sfc_render$3Z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3Z, _hoisted_3$3Z);
  }
  var brush = /* @__PURE__ */ _export_sfc(_sfc_main$3Z, [["render", _sfc_render$3Z]]);

  const _sfc_main$3Y = vue.defineComponent({
    name: "Burger"
  });
  const _hoisted_1$3Y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3Y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 512a32 32 0 00-32 32v64a32 32 0 0030.08 32H864a32 32 0 0032-32v-64a32 32 0 00-32-32H160zm736-58.56A96 96 0 01960 544v64a96 96 0 01-51.968 85.312L855.36 833.6a96 96 0 01-89.856 62.272H258.496A96 96 0 01168.64 833.6l-52.608-140.224A96 96 0 0164 608v-64a96 96 0 0164-90.56V448a384 384 0 11768 5.44zM832 448a320 320 0 00-640 0h640zM512 704H188.352l40.192 107.136a32 32 0 0029.952 20.736h507.008a32 32 0 0029.952-20.736L835.648 704H512z"
  }, null, -1);
  const _hoisted_3$3Y = [
    _hoisted_2$3Y
  ];
  function _sfc_render$3Y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3Y, _hoisted_3$3Y);
  }
  var burger = /* @__PURE__ */ _export_sfc(_sfc_main$3Y, [["render", _sfc_render$3Y]]);

  const _sfc_main$3X = vue.defineComponent({
    name: "Calendar"
  });
  const _hoisted_1$3X = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3X = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 384v512h768V192H768v32a32 32 0 11-64 0v-32H320v32a32 32 0 01-64 0v-32H128v128h768v64H128zm192-256h384V96a32 32 0 1164 0v32h160a32 32 0 0132 32v768a32 32 0 01-32 32H96a32 32 0 01-32-32V160a32 32 0 0132-32h160V96a32 32 0 0164 0v32zm-32 384h64a32 32 0 010 64h-64a32 32 0 010-64zm0 192h64a32 32 0 110 64h-64a32 32 0 110-64zm192-192h64a32 32 0 010 64h-64a32 32 0 010-64zm0 192h64a32 32 0 110 64h-64a32 32 0 110-64zm192-192h64a32 32 0 110 64h-64a32 32 0 110-64zm0 192h64a32 32 0 110 64h-64a32 32 0 110-64z"
  }, null, -1);
  const _hoisted_3$3X = [
    _hoisted_2$3X
  ];
  function _sfc_render$3X(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3X, _hoisted_3$3X);
  }
  var calendar = /* @__PURE__ */ _export_sfc(_sfc_main$3X, [["render", _sfc_render$3X]]);

  const _sfc_main$3W = vue.defineComponent({
    name: "CameraFilled"
  });
  const _hoisted_1$3W = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3W = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 224a64 64 0 00-64 64v512a64 64 0 0064 64h704a64 64 0 0064-64V288a64 64 0 00-64-64H748.416l-46.464-92.672A64 64 0 00644.736 96H379.328a64 64 0 00-57.216 35.392L275.776 224H160zm352 435.2a115.2 115.2 0 100-230.4 115.2 115.2 0 000 230.4zm0 140.8a256 256 0 110-512 256 256 0 010 512z"
  }, null, -1);
  const _hoisted_3$3W = [
    _hoisted_2$3W
  ];
  function _sfc_render$3W(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3W, _hoisted_3$3W);
  }
  var cameraFilled = /* @__PURE__ */ _export_sfc(_sfc_main$3W, [["render", _sfc_render$3W]]);

  const _sfc_main$3V = vue.defineComponent({
    name: "Camera"
  });
  const _hoisted_1$3V = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3V = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M896 256H128v576h768V256zm-199.424-64l-32.064-64h-304.96l-32 64h369.024zM96 192h160l46.336-92.608A64 64 0 01359.552 64h304.96a64 64 0 0157.216 35.328L768.192 192H928a32 32 0 0132 32v640a32 32 0 01-32 32H96a32 32 0 01-32-32V224a32 32 0 0132-32zm416 512a160 160 0 100-320 160 160 0 000 320zm0 64a224 224 0 110-448 224 224 0 010 448z"
  }, null, -1);
  const _hoisted_3$3V = [
    _hoisted_2$3V
  ];
  function _sfc_render$3V(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3V, _hoisted_3$3V);
  }
  var camera = /* @__PURE__ */ _export_sfc(_sfc_main$3V, [["render", _sfc_render$3V]]);

  const _sfc_main$3U = vue.defineComponent({
    name: "CaretBottom"
  });
  const _hoisted_1$3U = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3U = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 384l320 384 320-384z"
  }, null, -1);
  const _hoisted_3$3U = [
    _hoisted_2$3U
  ];
  function _sfc_render$3U(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3U, _hoisted_3$3U);
  }
  var caretBottom = /* @__PURE__ */ _export_sfc(_sfc_main$3U, [["render", _sfc_render$3U]]);

  const _sfc_main$3T = vue.defineComponent({
    name: "CaretLeft"
  });
  const _hoisted_1$3T = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3T = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M672 192L288 511.936 672 832z"
  }, null, -1);
  const _hoisted_3$3T = [
    _hoisted_2$3T
  ];
  function _sfc_render$3T(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3T, _hoisted_3$3T);
  }
  var caretLeft = /* @__PURE__ */ _export_sfc(_sfc_main$3T, [["render", _sfc_render$3T]]);

  const _sfc_main$3S = vue.defineComponent({
    name: "CaretRight"
  });
  const _hoisted_1$3S = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3S = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 192v640l384-320.064z"
  }, null, -1);
  const _hoisted_3$3S = [
    _hoisted_2$3S
  ];
  function _sfc_render$3S(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3S, _hoisted_3$3S);
  }
  var caretRight = /* @__PURE__ */ _export_sfc(_sfc_main$3S, [["render", _sfc_render$3S]]);

  const _sfc_main$3R = vue.defineComponent({
    name: "CaretTop"
  });
  const _hoisted_1$3R = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 320L192 704h639.936z"
  }, null, -1);
  const _hoisted_3$3R = [
    _hoisted_2$3R
  ];
  function _sfc_render$3R(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3R, _hoisted_3$3R);
  }
  var caretTop = /* @__PURE__ */ _export_sfc(_sfc_main$3R, [["render", _sfc_render$3R]]);

  const _sfc_main$3Q = vue.defineComponent({
    name: "Cellphone"
  });
  const _hoisted_1$3Q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3Q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 128a64 64 0 00-64 64v640a64 64 0 0064 64h512a64 64 0 0064-64V192a64 64 0 00-64-64H256zm0-64h512a128 128 0 01128 128v640a128 128 0 01-128 128H256a128 128 0 01-128-128V192A128 128 0 01256 64zm128 128h256a32 32 0 110 64H384a32 32 0 010-64zm128 640a64 64 0 110-128 64 64 0 010 128z"
  }, null, -1);
  const _hoisted_3$3Q = [
    _hoisted_2$3Q
  ];
  function _sfc_render$3Q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3Q, _hoisted_3$3Q);
  }
  var cellphone = /* @__PURE__ */ _export_sfc(_sfc_main$3Q, [["render", _sfc_render$3Q]]);

  const _sfc_main$3P = vue.defineComponent({
    name: "ChatDotRound"
  });
  const _hoisted_1$3P = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3P = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M174.72 855.68l135.296-45.12 23.68 11.84C388.096 849.536 448.576 864 512 864c211.84 0 384-166.784 384-352S723.84 160 512 160 128 326.784 128 512c0 69.12 24.96 139.264 70.848 199.232l22.08 28.8-46.272 115.584zm-45.248 82.56A32 32 0 0189.6 896l58.368-145.92C94.72 680.32 64 596.864 64 512 64 299.904 256 96 512 96s448 203.904 448 416-192 416-448 416a461.056 461.056 0 01-206.912-48.384l-175.616 58.56z"
  }, null, -1);
  const _hoisted_3$3P = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 563.2a51.2 51.2 0 110-102.4 51.2 51.2 0 010 102.4zm192 0a51.2 51.2 0 110-102.4 51.2 51.2 0 010 102.4zm-384 0a51.2 51.2 0 110-102.4 51.2 51.2 0 010 102.4z"
  }, null, -1);
  const _hoisted_4$16 = [
    _hoisted_2$3P,
    _hoisted_3$3P
  ];
  function _sfc_render$3P(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3P, _hoisted_4$16);
  }
  var chatDotRound = /* @__PURE__ */ _export_sfc(_sfc_main$3P, [["render", _sfc_render$3P]]);

  const _sfc_main$3O = vue.defineComponent({
    name: "ChatDotSquare"
  });
  const _hoisted_1$3O = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M273.536 736H800a64 64 0 0064-64V256a64 64 0 00-64-64H224a64 64 0 00-64 64v570.88L273.536 736zM296 800L147.968 918.4A32 32 0 0196 893.44V256a128 128 0 01128-128h576a128 128 0 01128 128v416a128 128 0 01-128 128H296z"
  }, null, -1);
  const _hoisted_3$3O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 499.2a51.2 51.2 0 110-102.4 51.2 51.2 0 010 102.4zm192 0a51.2 51.2 0 110-102.4 51.2 51.2 0 010 102.4zm-384 0a51.2 51.2 0 110-102.4 51.2 51.2 0 010 102.4z"
  }, null, -1);
  const _hoisted_4$15 = [
    _hoisted_2$3O,
    _hoisted_3$3O
  ];
  function _sfc_render$3O(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3O, _hoisted_4$15);
  }
  var chatDotSquare = /* @__PURE__ */ _export_sfc(_sfc_main$3O, [["render", _sfc_render$3O]]);

  const _sfc_main$3N = vue.defineComponent({
    name: "ChatLineRound"
  });
  const _hoisted_1$3N = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3N = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M174.72 855.68l135.296-45.12 23.68 11.84C388.096 849.536 448.576 864 512 864c211.84 0 384-166.784 384-352S723.84 160 512 160 128 326.784 128 512c0 69.12 24.96 139.264 70.848 199.232l22.08 28.8-46.272 115.584zm-45.248 82.56A32 32 0 0189.6 896l58.368-145.92C94.72 680.32 64 596.864 64 512 64 299.904 256 96 512 96s448 203.904 448 416-192 416-448 416a461.056 461.056 0 01-206.912-48.384l-175.616 58.56z"
  }, null, -1);
  const _hoisted_3$3N = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 576h320q32 0 32 32t-32 32H352q-32 0-32-32t32-32zM384 384h256q32 0 32 32t-32 32H384q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_4$14 = [
    _hoisted_2$3N,
    _hoisted_3$3N
  ];
  function _sfc_render$3N(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3N, _hoisted_4$14);
  }
  var chatLineRound = /* @__PURE__ */ _export_sfc(_sfc_main$3N, [["render", _sfc_render$3N]]);

  const _sfc_main$3M = vue.defineComponent({
    name: "ChatLineSquare"
  });
  const _hoisted_1$3M = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3M = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 826.88L273.536 736H800a64 64 0 0064-64V256a64 64 0 00-64-64H224a64 64 0 00-64 64v570.88zM296 800L147.968 918.4A32 32 0 0196 893.44V256a128 128 0 01128-128h576a128 128 0 01128 128v416a128 128 0 01-128 128H296z"
  }, null, -1);
  const _hoisted_3$3M = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 512h320q32 0 32 32t-32 32H352q-32 0-32-32t32-32zM352 320h320q32 0 32 32t-32 32H352q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_4$13 = [
    _hoisted_2$3M,
    _hoisted_3$3M
  ];
  function _sfc_render$3M(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3M, _hoisted_4$13);
  }
  var chatLineSquare = /* @__PURE__ */ _export_sfc(_sfc_main$3M, [["render", _sfc_render$3M]]);

  const _sfc_main$3L = vue.defineComponent({
    name: "ChatRound"
  });
  const _hoisted_1$3L = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3L = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M174.72 855.68l130.048-43.392 23.424 11.392C382.4 849.984 444.352 864 512 864c223.744 0 384-159.872 384-352 0-192.832-159.104-352-384-352S128 319.168 128 512a341.12 341.12 0 0069.248 204.288l21.632 28.8-44.16 110.528zm-45.248 82.56A32 32 0 0189.6 896l56.512-141.248A405.12 405.12 0 0164 512C64 299.904 235.648 96 512 96s448 203.904 448 416-173.44 416-448 416c-79.68 0-150.848-17.152-211.712-46.72l-170.88 56.96z"
  }, null, -1);
  const _hoisted_3$3L = [
    _hoisted_2$3L
  ];
  function _sfc_render$3L(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3L, _hoisted_3$3L);
  }
  var chatRound = /* @__PURE__ */ _export_sfc(_sfc_main$3L, [["render", _sfc_render$3L]]);

  const _sfc_main$3K = vue.defineComponent({
    name: "ChatSquare"
  });
  const _hoisted_1$3K = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3K = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M273.536 736H800a64 64 0 0064-64V256a64 64 0 00-64-64H224a64 64 0 00-64 64v570.88L273.536 736zM296 800L147.968 918.4A32 32 0 0196 893.44V256a128 128 0 01128-128h576a128 128 0 01128 128v416a128 128 0 01-128 128H296z"
  }, null, -1);
  const _hoisted_3$3K = [
    _hoisted_2$3K
  ];
  function _sfc_render$3K(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3K, _hoisted_3$3K);
  }
  var chatSquare = /* @__PURE__ */ _export_sfc(_sfc_main$3K, [["render", _sfc_render$3K]]);

  const _sfc_main$3J = vue.defineComponent({
    name: "Check"
  });
  const _hoisted_1$3J = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3J = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M406.656 706.944L195.84 496.256a32 32 0 10-45.248 45.248l256 256 512-512a32 32 0 00-45.248-45.248L406.592 706.944z"
  }, null, -1);
  const _hoisted_3$3J = [
    _hoisted_2$3J
  ];
  function _sfc_render$3J(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3J, _hoisted_3$3J);
  }
  var check = /* @__PURE__ */ _export_sfc(_sfc_main$3J, [["render", _sfc_render$3J]]);

  const _sfc_main$3I = vue.defineComponent({
    name: "Checked"
  });
  const _hoisted_1$3I = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3I = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 192h160v736H160V192h160.064v64H704v-64zM311.616 537.28l-45.312 45.248L447.36 763.52l316.8-316.8-45.312-45.184L447.36 673.024 311.616 537.28zM384 192V96h256v96H384z"
  }, null, -1);
  const _hoisted_3$3I = [
    _hoisted_2$3I
  ];
  function _sfc_render$3I(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3I, _hoisted_3$3I);
  }
  var checked = /* @__PURE__ */ _export_sfc(_sfc_main$3I, [["render", _sfc_render$3I]]);

  const _sfc_main$3H = vue.defineComponent({
    name: "Cherry"
  });
  const _hoisted_1$3H = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3H = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M261.056 449.6c13.824-69.696 34.88-128.96 63.36-177.728 23.744-40.832 61.12-88.64 112.256-143.872H320a32 32 0 010-64h384a32 32 0 110 64H554.752c14.912 39.168 41.344 86.592 79.552 141.76 47.36 68.48 84.8 106.752 106.304 114.304a224 224 0 11-84.992 14.784c-22.656-22.912-47.04-53.76-73.92-92.608-38.848-56.128-67.008-105.792-84.352-149.312-55.296 58.24-94.528 107.52-117.76 147.2-23.168 39.744-41.088 88.768-53.568 147.072a224.064 224.064 0 11-64.96-1.6zM288 832a160 160 0 100-320 160 160 0 000 320zm448-64a160 160 0 100-320 160 160 0 000 320z"
  }, null, -1);
  const _hoisted_3$3H = [
    _hoisted_2$3H
  ];
  function _sfc_render$3H(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3H, _hoisted_3$3H);
  }
  var cherry = /* @__PURE__ */ _export_sfc(_sfc_main$3H, [["render", _sfc_render$3H]]);

  const _sfc_main$3G = vue.defineComponent({
    name: "Chicken"
  });
  const _hoisted_1$3G = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3G = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M349.952 716.992L478.72 588.16a106.688 106.688 0 01-26.176-19.072 106.688 106.688 0 01-19.072-26.176L304.704 671.744c.768 3.072 1.472 6.144 2.048 9.216l2.048 31.936 31.872 1.984c3.136.64 6.208 1.28 9.28 2.112zm57.344 33.152a128 128 0 11-216.32 114.432l-1.92-32-32-1.92a128 128 0 11114.432-216.32L416.64 469.248c-2.432-101.44 58.112-239.104 149.056-330.048 107.328-107.328 231.296-85.504 316.8 0 85.44 85.44 107.328 209.408 0 316.8-91.008 90.88-228.672 151.424-330.112 149.056L407.296 750.08zm90.496-226.304c49.536 49.536 233.344-7.04 339.392-113.088 78.208-78.208 63.232-163.072 0-226.304-63.168-63.232-148.032-78.208-226.24 0C504.896 290.496 448.32 474.368 497.792 523.84zM244.864 708.928a64 64 0 10-59.84 59.84l56.32-3.52 3.52-56.32zm8.064 127.68a64 64 0 1059.84-59.84l-56.32 3.52-3.52 56.32z"
  }, null, -1);
  const _hoisted_3$3G = [
    _hoisted_2$3G
  ];
  function _sfc_render$3G(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3G, _hoisted_3$3G);
  }
  var chicken = /* @__PURE__ */ _export_sfc(_sfc_main$3G, [["render", _sfc_render$3G]]);

  const _sfc_main$3F = vue.defineComponent({
    name: "CircleCheckFilled"
  });
  const _hoisted_1$3F = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3F = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm-55.808 536.384l-99.52-99.584a38.4 38.4 0 10-54.336 54.336l126.72 126.72a38.272 38.272 0 0054.336 0l262.4-262.464a38.4 38.4 0 10-54.272-54.336L456.192 600.384z"
  }, null, -1);
  const _hoisted_3$3F = [
    _hoisted_2$3F
  ];
  function _sfc_render$3F(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3F, _hoisted_3$3F);
  }
  var circleCheckFilled = /* @__PURE__ */ _export_sfc(_sfc_main$3F, [["render", _sfc_render$3F]]);

  const _sfc_main$3E = vue.defineComponent({
    name: "CircleCheck"
  });
  const _hoisted_1$3E = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$3E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M745.344 361.344a32 32 0 0145.312 45.312l-288 288a32 32 0 01-45.312 0l-160-160a32 32 0 1145.312-45.312L480 626.752l265.344-265.408z"
  }, null, -1);
  const _hoisted_4$12 = [
    _hoisted_2$3E,
    _hoisted_3$3E
  ];
  function _sfc_render$3E(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3E, _hoisted_4$12);
  }
  var circleCheck = /* @__PURE__ */ _export_sfc(_sfc_main$3E, [["render", _sfc_render$3E]]);

  const _sfc_main$3D = vue.defineComponent({
    name: "CircleCloseFilled"
  });
  const _hoisted_1$3D = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3D = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm0 393.664L407.936 353.6a38.4 38.4 0 10-54.336 54.336L457.664 512 353.6 616.064a38.4 38.4 0 1054.336 54.336L512 566.336 616.064 670.4a38.4 38.4 0 1054.336-54.336L566.336 512 670.4 407.936a38.4 38.4 0 10-54.336-54.336L512 457.664z"
  }, null, -1);
  const _hoisted_3$3D = [
    _hoisted_2$3D
  ];
  function _sfc_render$3D(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3D, _hoisted_3$3D);
  }
  var circleCloseFilled = /* @__PURE__ */ _export_sfc(_sfc_main$3D, [["render", _sfc_render$3D]]);

  const _sfc_main$3C = vue.defineComponent({
    name: "CircleClose"
  });
  const _hoisted_1$3C = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M466.752 512l-90.496-90.496a32 32 0 0145.248-45.248L512 466.752l90.496-90.496a32 32 0 1145.248 45.248L557.248 512l90.496 90.496a32 32 0 11-45.248 45.248L512 557.248l-90.496 90.496a32 32 0 01-45.248-45.248L466.752 512z"
  }, null, -1);
  const _hoisted_3$3C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_4$11 = [
    _hoisted_2$3C,
    _hoisted_3$3C
  ];
  function _sfc_render$3C(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3C, _hoisted_4$11);
  }
  var circleClose = /* @__PURE__ */ _export_sfc(_sfc_main$3C, [["render", _sfc_render$3C]]);

  const _sfc_main$3B = vue.defineComponent({
    name: "CirclePlusFilled"
  });
  const _hoisted_1$3B = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3B = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm-38.4 409.6H326.4a38.4 38.4 0 100 76.8h147.2v147.2a38.4 38.4 0 0076.8 0V550.4h147.2a38.4 38.4 0 000-76.8H550.4V326.4a38.4 38.4 0 10-76.8 0v147.2z"
  }, null, -1);
  const _hoisted_3$3B = [
    _hoisted_2$3B
  ];
  function _sfc_render$3B(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3B, _hoisted_3$3B);
  }
  var circlePlusFilled = /* @__PURE__ */ _export_sfc(_sfc_main$3B, [["render", _sfc_render$3B]]);

  const _sfc_main$3A = vue.defineComponent({
    name: "CirclePlus"
  });
  const _hoisted_1$3A = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3A = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 480h320a32 32 0 110 64H352a32 32 0 010-64z"
  }, null, -1);
  const _hoisted_3$3A = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 672V352a32 32 0 1164 0v320a32 32 0 01-64 0z"
  }, null, -1);
  const _hoisted_4$10 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_5$h = [
    _hoisted_2$3A,
    _hoisted_3$3A,
    _hoisted_4$10
  ];
  function _sfc_render$3A(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3A, _hoisted_5$h);
  }
  var circlePlus = /* @__PURE__ */ _export_sfc(_sfc_main$3A, [["render", _sfc_render$3A]]);

  const _sfc_main$3z = vue.defineComponent({
    name: "Clock"
  });
  const _hoisted_1$3z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$3z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 256a32 32 0 0132 32v256a32 32 0 01-64 0V288a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4$$ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 512h256q32 0 32 32t-32 32H480q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_5$g = [
    _hoisted_2$3z,
    _hoisted_3$3z,
    _hoisted_4$$
  ];
  function _sfc_render$3z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3z, _hoisted_5$g);
  }
  var clock = /* @__PURE__ */ _export_sfc(_sfc_main$3z, [["render", _sfc_render$3z]]);

  const _sfc_main$3y = vue.defineComponent({
    name: "CloseBold"
  });
  const _hoisted_1$3y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M195.2 195.2a64 64 0 0190.496 0L512 421.504 738.304 195.2a64 64 0 0190.496 90.496L602.496 512 828.8 738.304a64 64 0 01-90.496 90.496L512 602.496 285.696 828.8a64 64 0 01-90.496-90.496L421.504 512 195.2 285.696a64 64 0 010-90.496z"
  }, null, -1);
  const _hoisted_3$3y = [
    _hoisted_2$3y
  ];
  function _sfc_render$3y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3y, _hoisted_3$3y);
  }
  var closeBold = /* @__PURE__ */ _export_sfc(_sfc_main$3y, [["render", _sfc_render$3y]]);

  const _sfc_main$3x = vue.defineComponent({
    name: "Close"
  });
  const _hoisted_1$3x = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3x = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M764.288 214.592L512 466.88 259.712 214.592a31.936 31.936 0 00-45.12 45.12L466.752 512 214.528 764.224a31.936 31.936 0 1045.12 45.184L512 557.184l252.288 252.288a31.936 31.936 0 0045.12-45.12L557.12 512.064l252.288-252.352a31.936 31.936 0 10-45.12-45.184z"
  }, null, -1);
  const _hoisted_3$3x = [
    _hoisted_2$3x
  ];
  function _sfc_render$3x(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3x, _hoisted_3$3x);
  }
  var close = /* @__PURE__ */ _export_sfc(_sfc_main$3x, [["render", _sfc_render$3x]]);

  const _sfc_main$3w = vue.defineComponent({
    name: "Cloudy"
  });
  const _hoisted_1$3w = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3w = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M598.4 831.872H328.192a256 256 0 01-34.496-510.528A352 352 0 11598.4 831.872zm-271.36-64h272.256a288 288 0 10-248.512-417.664L335.04 381.44l-34.816 3.584a192 192 0 0026.88 382.848z"
  }, null, -1);
  const _hoisted_3$3w = [
    _hoisted_2$3w
  ];
  function _sfc_render$3w(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3w, _hoisted_3$3w);
  }
  var cloudy = /* @__PURE__ */ _export_sfc(_sfc_main$3w, [["render", _sfc_render$3w]]);

  const _sfc_main$3v = vue.defineComponent({
    name: "CoffeeCup"
  });
  const _hoisted_1$3v = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3v = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 192a192 192 0 11-8 383.808A256.128 256.128 0 01512 768H320A256 256 0 0164 512V160a32 32 0 0132-32h640a32 32 0 0132 32v32zm0 64v256a128 128 0 100-256zM96 832h640a32 32 0 110 64H96a32 32 0 110-64zm32-640v320a192 192 0 00192 192h192a192 192 0 00192-192V192H128z"
  }, null, -1);
  const _hoisted_3$3v = [
    _hoisted_2$3v
  ];
  function _sfc_render$3v(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3v, _hoisted_3$3v);
  }
  var coffeeCup = /* @__PURE__ */ _export_sfc(_sfc_main$3v, [["render", _sfc_render$3v]]);

  const _sfc_main$3u = vue.defineComponent({
    name: "Coffee"
  });
  const _hoisted_1$3u = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3u = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M822.592 192h14.272a32 32 0 0131.616 26.752l21.312 128A32 32 0 01858.24 384h-49.344l-39.04 546.304A32 32 0 01737.92 960H285.824a32 32 0 01-32-29.696L214.912 384H165.76a32 32 0 01-31.552-37.248l21.312-128A32 32 0 01187.136 192h14.016l-6.72-93.696A32 32 0 01226.368 64h571.008a32 32 0 0131.936 34.304L822.592 192zm-64.128 0l4.544-64H260.736l4.544 64h493.184zm-548.16 128H820.48l-10.688-64H214.208l-10.688 64h6.784zm68.736 64l36.544 512H708.16l36.544-512H279.04z"
  }, null, -1);
  const _hoisted_3$3u = [
    _hoisted_2$3u
  ];
  function _sfc_render$3u(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3u, _hoisted_3$3u);
  }
  var coffee = /* @__PURE__ */ _export_sfc(_sfc_main$3u, [["render", _sfc_render$3u]]);

  const _sfc_main$3t = vue.defineComponent({
    name: "Coin"
  });
  const _hoisted_1$3t = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M161.92 580.736l29.888 58.88C171.328 659.776 160 681.728 160 704c0 82.304 155.328 160 352 160s352-77.696 352-160c0-22.272-11.392-44.16-31.808-64.32l30.464-58.432C903.936 615.808 928 657.664 928 704c0 129.728-188.544 224-416 224S96 833.728 96 704c0-46.592 24.32-88.576 65.92-123.264z"
  }, null, -1);
  const _hoisted_3$3t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M161.92 388.736l29.888 58.88C171.328 467.84 160 489.792 160 512c0 82.304 155.328 160 352 160s352-77.696 352-160c0-22.272-11.392-44.16-31.808-64.32l30.464-58.432C903.936 423.808 928 465.664 928 512c0 129.728-188.544 224-416 224S96 641.728 96 512c0-46.592 24.32-88.576 65.92-123.264z"
  }, null, -1);
  const _hoisted_4$_ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 544c-227.456 0-416-94.272-416-224S284.544 96 512 96s416 94.272 416 224-188.544 224-416 224zm0-64c196.672 0 352-77.696 352-160S708.672 160 512 160s-352 77.696-352 160 155.328 160 352 160z"
  }, null, -1);
  const _hoisted_5$f = [
    _hoisted_2$3t,
    _hoisted_3$3t,
    _hoisted_4$_
  ];
  function _sfc_render$3t(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3t, _hoisted_5$f);
  }
  var coin = /* @__PURE__ */ _export_sfc(_sfc_main$3t, [["render", _sfc_render$3t]]);

  const _sfc_main$3s = vue.defineComponent({
    name: "ColdDrink"
  });
  const _hoisted_1$3s = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 64a192 192 0 11-69.952 370.88L480 725.376V896h96a32 32 0 110 64H320a32 32 0 110-64h96V725.376L76.8 273.536a64 64 0 01-12.8-38.4v-10.688a32 32 0 0132-32h71.808l-65.536-83.84a32 32 0 0150.432-39.424l96.256 123.264h337.728A192.064 192.064 0 01768 64zM656.896 192.448H800a32 32 0 0132 32v10.624a64 64 0 01-12.8 38.4l-80.448 107.2a128 128 0 10-81.92-188.16v-.064zm-357.888 64l129.472 165.76a32 32 0 01-50.432 39.36l-160.256-205.12H144l304 404.928 304-404.928H299.008z"
  }, null, -1);
  const _hoisted_3$3s = [
    _hoisted_2$3s
  ];
  function _sfc_render$3s(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3s, _hoisted_3$3s);
  }
  var coldDrink = /* @__PURE__ */ _export_sfc(_sfc_main$3s, [["render", _sfc_render$3s]]);

  const _sfc_main$3r = vue.defineComponent({
    name: "CollectionTag"
  });
  const _hoisted_1$3r = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3r = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 128v698.88l196.032-156.864a96 96 0 01119.936 0L768 826.816V128H256zm-32-64h576a32 32 0 0132 32v797.44a32 32 0 01-51.968 24.96L531.968 720a32 32 0 00-39.936 0L243.968 918.4A32 32 0 01192 893.44V96a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$3r = [
    _hoisted_2$3r
  ];
  function _sfc_render$3r(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3r, _hoisted_3$3r);
  }
  var collectionTag = /* @__PURE__ */ _export_sfc(_sfc_main$3r, [["render", _sfc_render$3r]]);

  const _sfc_main$3q = vue.defineComponent({
    name: "Collection"
  });
  const _hoisted_1$3q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 736h640V128H256a64 64 0 00-64 64v544zm64-672h608a32 32 0 0132 32v672a32 32 0 01-32 32H160l-32 57.536V192A128 128 0 01256 64z"
  }, null, -1);
  const _hoisted_3$3q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M240 800a48 48 0 100 96h592v-96H240zm0-64h656v160a64 64 0 01-64 64H240a112 112 0 010-224zm144-608v250.88l96-76.8 96 76.8V128H384zm-64-64h320v381.44a32 32 0 01-51.968 24.96L480 384l-108.032 86.4A32 32 0 01320 445.44V64z"
  }, null, -1);
  const _hoisted_4$Z = [
    _hoisted_2$3q,
    _hoisted_3$3q
  ];
  function _sfc_render$3q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3q, _hoisted_4$Z);
  }
  var collection = /* @__PURE__ */ _export_sfc(_sfc_main$3q, [["render", _sfc_render$3q]]);

  const _sfc_main$3p = vue.defineComponent({
    name: "Comment"
  });
  const _hoisted_1$3p = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3p = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M736 504a56 56 0 110-112 56 56 0 010 112zm-224 0a56 56 0 110-112 56 56 0 010 112zm-224 0a56 56 0 110-112 56 56 0 010 112zM128 128v640h192v160l224-160h352V128H128z"
  }, null, -1);
  const _hoisted_3$3p = [
    _hoisted_2$3p
  ];
  function _sfc_render$3p(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3p, _hoisted_3$3p);
  }
  var comment = /* @__PURE__ */ _export_sfc(_sfc_main$3p, [["render", _sfc_render$3p]]);

  const _sfc_main$3o = vue.defineComponent({
    name: "Compass"
  });
  const _hoisted_1$3o = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3o = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$3o = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M725.888 315.008C676.48 428.672 624 513.28 568.576 568.64c-55.424 55.424-139.968 107.904-253.568 157.312a12.8 12.8 0 01-16.896-16.832c49.536-113.728 102.016-198.272 157.312-253.632 55.36-55.296 139.904-107.776 253.632-157.312a12.8 12.8 0 0116.832 16.832z"
  }, null, -1);
  const _hoisted_4$Y = [
    _hoisted_2$3o,
    _hoisted_3$3o
  ];
  function _sfc_render$3o(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3o, _hoisted_4$Y);
  }
  var compass = /* @__PURE__ */ _export_sfc(_sfc_main$3o, [["render", _sfc_render$3o]]);

  const _sfc_main$3n = vue.defineComponent({
    name: "Connection"
  });
  const _hoisted_1$3n = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3n = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 384v64H448a128 128 0 00-128 128v128a128 128 0 00128 128h320a128 128 0 00128-128V576a128 128 0 00-64-110.848V394.88c74.56 26.368 128 97.472 128 181.056v128a192 192 0 01-192 192H448a192 192 0 01-192-192V576a192 192 0 01192-192h192z"
  }, null, -1);
  const _hoisted_3$3n = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 640v-64h192a128 128 0 00128-128V320a128 128 0 00-128-128H256a128 128 0 00-128 128v128a128 128 0 0064 110.848v70.272A192.064 192.064 0 0164 448V320a192 192 0 01192-192h320a192 192 0 01192 192v128a192 192 0 01-192 192H384z"
  }, null, -1);
  const _hoisted_4$X = [
    _hoisted_2$3n,
    _hoisted_3$3n
  ];
  function _sfc_render$3n(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3n, _hoisted_4$X);
  }
  var connection = /* @__PURE__ */ _export_sfc(_sfc_main$3n, [["render", _sfc_render$3n]]);

  const _sfc_main$3m = vue.defineComponent({
    name: "Coordinate"
  });
  const _hoisted_1$3m = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 512h64v320h-64z"
  }, null, -1);
  const _hoisted_3$3m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 896h640a64 64 0 00-64-64H256a64 64 0 00-64 64zm64-128h512a128 128 0 01128 128v64H128v-64a128 128 0 01128-128zm256-256a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512z"
  }, null, -1);
  const _hoisted_4$W = [
    _hoisted_2$3m,
    _hoisted_3$3m
  ];
  function _sfc_render$3m(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3m, _hoisted_4$W);
  }
  var coordinate = /* @__PURE__ */ _export_sfc(_sfc_main$3m, [["render", _sfc_render$3m]]);

  const _sfc_main$3l = vue.defineComponent({
    name: "CopyDocument"
  });
  const _hoisted_1$3l = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 832a128 128 0 01-128 128H192A128 128 0 0164 832V384a128 128 0 01128-128v64a64 64 0 00-64 64v448a64 64 0 0064 64h448a64 64 0 0064-64h64z"
  }, null, -1);
  const _hoisted_3$3l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 128a64 64 0 00-64 64v448a64 64 0 0064 64h448a64 64 0 0064-64V192a64 64 0 00-64-64H384zm0-64h448a128 128 0 01128 128v448a128 128 0 01-128 128H384a128 128 0 01-128-128V192A128 128 0 01384 64z"
  }, null, -1);
  const _hoisted_4$V = [
    _hoisted_2$3l,
    _hoisted_3$3l
  ];
  function _sfc_render$3l(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3l, _hoisted_4$V);
  }
  var copyDocument = /* @__PURE__ */ _export_sfc(_sfc_main$3l, [["render", _sfc_render$3l]]);

  const _sfc_main$3k = vue.defineComponent({
    name: "Cpu"
  });
  const _hoisted_1$3k = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M320 256a64 64 0 00-64 64v384a64 64 0 0064 64h384a64 64 0 0064-64V320a64 64 0 00-64-64H320zm0-64h384a128 128 0 01128 128v384a128 128 0 01-128 128H320a128 128 0 01-128-128V320a128 128 0 01128-128z"
  }, null, -1);
  const _hoisted_3$3k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a32 32 0 0132 32v128h-64V96a32 32 0 0132-32zm160 0a32 32 0 0132 32v128h-64V96a32 32 0 0132-32zm-320 0a32 32 0 0132 32v128h-64V96a32 32 0 0132-32zm160 896a32 32 0 01-32-32V800h64v128a32 32 0 01-32 32zm160 0a32 32 0 01-32-32V800h64v128a32 32 0 01-32 32zm-320 0a32 32 0 01-32-32V800h64v128a32 32 0 01-32 32zM64 512a32 32 0 0132-32h128v64H96a32 32 0 01-32-32zm0-160a32 32 0 0132-32h128v64H96a32 32 0 01-32-32zm0 320a32 32 0 0132-32h128v64H96a32 32 0 01-32-32zm896-160a32 32 0 01-32 32H800v-64h128a32 32 0 0132 32zm0-160a32 32 0 01-32 32H800v-64h128a32 32 0 0132 32zm0 320a32 32 0 01-32 32H800v-64h128a32 32 0 0132 32z"
  }, null, -1);
  const _hoisted_4$U = [
    _hoisted_2$3k,
    _hoisted_3$3k
  ];
  function _sfc_render$3k(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3k, _hoisted_4$U);
  }
  var cpu = /* @__PURE__ */ _export_sfc(_sfc_main$3k, [["render", _sfc_render$3k]]);

  const _sfc_main$3j = vue.defineComponent({
    name: "CreditCard"
  });
  const _hoisted_1$3j = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M896 324.096c0-42.368-2.496-55.296-9.536-68.48a52.352 52.352 0 00-22.144-22.08c-13.12-7.04-26.048-9.536-68.416-9.536H228.096c-42.368 0-55.296 2.496-68.48 9.536a52.352 52.352 0 00-22.08 22.144c-7.04 13.12-9.536 26.048-9.536 68.416v375.808c0 42.368 2.496 55.296 9.536 68.48a52.352 52.352 0 0022.144 22.08c13.12 7.04 26.048 9.536 68.416 9.536h567.808c42.368 0 55.296-2.496 68.48-9.536a52.352 52.352 0 0022.08-22.144c7.04-13.12 9.536-26.048 9.536-68.416V324.096zm64 0v375.808c0 57.088-5.952 77.76-17.088 98.56-11.136 20.928-27.52 37.312-48.384 48.448-20.864 11.136-41.6 17.088-98.56 17.088H228.032c-57.088 0-77.76-5.952-98.56-17.088a116.288 116.288 0 01-48.448-48.384c-11.136-20.864-17.088-41.6-17.088-98.56V324.032c0-57.088 5.952-77.76 17.088-98.56 11.136-20.928 27.52-37.312 48.384-48.448 20.864-11.136 41.6-17.088 98.56-17.088H795.84c57.088 0 77.76 5.952 98.56 17.088 20.928 11.136 37.312 27.52 48.448 48.384 11.136 20.864 17.088 41.6 17.088 98.56z"
  }, null, -1);
  const _hoisted_3$3j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M64 320h896v64H64v-64zm0 128h896v64H64v-64zm128 192h256v64H192z"
  }, null, -1);
  const _hoisted_4$T = [
    _hoisted_2$3j,
    _hoisted_3$3j
  ];
  function _sfc_render$3j(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3j, _hoisted_4$T);
  }
  var creditCard = /* @__PURE__ */ _export_sfc(_sfc_main$3j, [["render", _sfc_render$3j]]);

  const _sfc_main$3i = vue.defineComponent({
    name: "Crop"
  });
  const _hoisted_1$3i = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3i = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 768h672a32 32 0 110 64H224a32 32 0 01-32-32V96a32 32 0 0164 0v672z"
  }, null, -1);
  const _hoisted_3$3i = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M832 224v704a32 32 0 11-64 0V256H96a32 32 0 010-64h704a32 32 0 0132 32z"
  }, null, -1);
  const _hoisted_4$S = [
    _hoisted_2$3i,
    _hoisted_3$3i
  ];
  function _sfc_render$3i(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3i, _hoisted_4$S);
  }
  var crop = /* @__PURE__ */ _export_sfc(_sfc_main$3i, [["render", _sfc_render$3i]]);

  const _sfc_main$3h = vue.defineComponent({
    name: "DArrowLeft"
  });
  const _hoisted_1$3h = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3h = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M529.408 149.376a29.12 29.12 0 0141.728 0 30.592 30.592 0 010 42.688L259.264 511.936l311.872 319.936a30.592 30.592 0 01-.512 43.264 29.12 29.12 0 01-41.216-.512L197.76 534.272a32 32 0 010-44.672l331.648-340.224zm256 0a29.12 29.12 0 0141.728 0 30.592 30.592 0 010 42.688L515.264 511.936l311.872 319.936a30.592 30.592 0 01-.512 43.264 29.12 29.12 0 01-41.216-.512L453.76 534.272a32 32 0 010-44.672l331.648-340.224z"
  }, null, -1);
  const _hoisted_3$3h = [
    _hoisted_2$3h
  ];
  function _sfc_render$3h(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3h, _hoisted_3$3h);
  }
  var dArrowLeft = /* @__PURE__ */ _export_sfc(_sfc_main$3h, [["render", _sfc_render$3h]]);

  const _sfc_main$3g = vue.defineComponent({
    name: "DArrowRight"
  });
  const _hoisted_1$3g = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3g = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M452.864 149.312a29.12 29.12 0 0141.728.064L826.24 489.664a32 32 0 010 44.672L494.592 874.624a29.12 29.12 0 01-41.728 0 30.592 30.592 0 010-42.752L764.736 512 452.864 192a30.592 30.592 0 010-42.688zm-256 0a29.12 29.12 0 0141.728.064L570.24 489.664a32 32 0 010 44.672L238.592 874.624a29.12 29.12 0 01-41.728 0 30.592 30.592 0 010-42.752L508.736 512 196.864 192a30.592 30.592 0 010-42.688z"
  }, null, -1);
  const _hoisted_3$3g = [
    _hoisted_2$3g
  ];
  function _sfc_render$3g(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3g, _hoisted_3$3g);
  }
  var dArrowRight = /* @__PURE__ */ _export_sfc(_sfc_main$3g, [["render", _sfc_render$3g]]);

  const _sfc_main$3f = vue.defineComponent({
    name: "DCaret"
  });
  const _hoisted_1$3f = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 128l288 320H224l288-320zM224 576h576L512 896 224 576z"
  }, null, -1);
  const _hoisted_3$3f = [
    _hoisted_2$3f
  ];
  function _sfc_render$3f(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3f, _hoisted_3$3f);
  }
  var dCaret = /* @__PURE__ */ _export_sfc(_sfc_main$3f, [["render", _sfc_render$3f]]);

  const _sfc_main$3e = vue.defineComponent({
    name: "DataAnalysis"
  });
  const _hoisted_1$3e = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3e = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M665.216 768l110.848 192h-73.856L591.36 768H433.024L322.176 960H248.32l110.848-192H160a32 32 0 01-32-32V192H64a32 32 0 010-64h896a32 32 0 110 64h-64v544a32 32 0 01-32 32H665.216zM832 192H192v512h640V192zM352 448a32 32 0 0132 32v64a32 32 0 01-64 0v-64a32 32 0 0132-32zm160-64a32 32 0 0132 32v128a32 32 0 01-64 0V416a32 32 0 0132-32zm160-64a32 32 0 0132 32v192a32 32 0 11-64 0V352a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$3e = [
    _hoisted_2$3e
  ];
  function _sfc_render$3e(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3e, _hoisted_3$3e);
  }
  var dataAnalysis = /* @__PURE__ */ _export_sfc(_sfc_main$3e, [["render", _sfc_render$3e]]);

  const _sfc_main$3d = vue.defineComponent({
    name: "DataBoard"
  });
  const _hoisted_1$3d = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3d = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M32 128h960v64H32z"
  }, null, -1);
  const _hoisted_3$3d = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 192v512h640V192H192zm-64-64h768v608a32 32 0 01-32 32H160a32 32 0 01-32-32V128z"
  }, null, -1);
  const _hoisted_4$R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M322.176 960H248.32l144.64-250.56 55.424 32L322.176 960zm453.888 0h-73.856L576 741.44l55.424-32L776.064 960z"
  }, null, -1);
  const _hoisted_5$e = [
    _hoisted_2$3d,
    _hoisted_3$3d,
    _hoisted_4$R
  ];
  function _sfc_render$3d(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3d, _hoisted_5$e);
  }
  var dataBoard = /* @__PURE__ */ _export_sfc(_sfc_main$3d, [["render", _sfc_render$3d]]);

  const _sfc_main$3c = vue.defineComponent({
    name: "DataLine"
  });
  const _hoisted_1$3c = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3c = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M359.168 768H160a32 32 0 01-32-32V192H64a32 32 0 010-64h896a32 32 0 110 64h-64v544a32 32 0 01-32 32H665.216l110.848 192h-73.856L591.36 768H433.024L322.176 960H248.32l110.848-192zM832 192H192v512h640V192zM342.656 534.656a32 32 0 11-45.312-45.312L444.992 341.76l125.44 94.08L679.04 300.032a32 32 0 1149.92 39.936L581.632 524.224 451.008 426.24 342.656 534.592z"
  }, null, -1);
  const _hoisted_3$3c = [
    _hoisted_2$3c
  ];
  function _sfc_render$3c(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3c, _hoisted_3$3c);
  }
  var dataLine = /* @__PURE__ */ _export_sfc(_sfc_main$3c, [["render", _sfc_render$3c]]);

  const _sfc_main$3b = vue.defineComponent({
    name: "DeleteFilled"
  });
  const _hoisted_1$3b = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 192V95.936a32 32 0 0132-32h256a32 32 0 0132 32V192h256a32 32 0 110 64H96a32 32 0 010-64h256zm64 0h192v-64H416v64zM192 960a32 32 0 01-32-32V256h704v672a32 32 0 01-32 32H192zm224-192a32 32 0 0032-32V416a32 32 0 00-64 0v320a32 32 0 0032 32zm192 0a32 32 0 0032-32V416a32 32 0 00-64 0v320a32 32 0 0032 32z"
  }, null, -1);
  const _hoisted_3$3b = [
    _hoisted_2$3b
  ];
  function _sfc_render$3b(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3b, _hoisted_3$3b);
  }
  var deleteFilled = /* @__PURE__ */ _export_sfc(_sfc_main$3b, [["render", _sfc_render$3b]]);

  const _sfc_main$3a = vue.defineComponent({
    name: "DeleteLocation"
  });
  const _hoisted_1$3a = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 896h448q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_3$3a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M800 416a288 288 0 10-576 0c0 118.144 94.528 272.128 288 456.576C705.472 688.128 800 534.144 800 416zM512 960C277.312 746.688 160 565.312 160 416a352 352 0 01704 0c0 149.312-117.312 330.688-352 544z"
  }, null, -1);
  const _hoisted_4$Q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 384h256q32 0 32 32t-32 32H384q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_5$d = [
    _hoisted_2$3a,
    _hoisted_3$3a,
    _hoisted_4$Q
  ];
  function _sfc_render$3a(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3a, _hoisted_5$d);
  }
  var deleteLocation = /* @__PURE__ */ _export_sfc(_sfc_main$3a, [["render", _sfc_render$3a]]);

  const _sfc_main$39 = vue.defineComponent({
    name: "Delete"
  });
  const _hoisted_1$39 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$39 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 256H96a32 32 0 010-64h256V95.936a32 32 0 0132-32h256a32 32 0 0132 32V192h256a32 32 0 110 64h-64v672a32 32 0 01-32 32H192a32 32 0 01-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 01-32-32V416a32 32 0 0164 0v320a32 32 0 01-32 32zm192 0a32 32 0 01-32-32V416a32 32 0 0164 0v320a32 32 0 01-32 32z"
  }, null, -1);
  const _hoisted_3$39 = [
    _hoisted_2$39
  ];
  function _sfc_render$39(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$39, _hoisted_3$39);
  }
  var _delete = /* @__PURE__ */ _export_sfc(_sfc_main$39, [["render", _sfc_render$39]]);

  const _sfc_main$38 = vue.defineComponent({
    name: "Dessert"
  });
  const _hoisted_1$38 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$38 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 416v-48a144 144 0 01168.64-141.888 224.128 224.128 0 01430.72 0A144 144 0 01896 368v48a384 384 0 01-352 382.72V896h-64v-97.28A384 384 0 01128 416zm287.104-32.064h193.792a143.808 143.808 0 0158.88-132.736 160.064 160.064 0 00-311.552 0 143.808 143.808 0 0158.88 132.8zm-72.896 0a72 72 0 10-140.48 0h140.48zm339.584 0h140.416a72 72 0 10-140.48 0zM512 736a320 320 0 00318.4-288.064H193.6A320 320 0 00512 736zM384 896.064h256a32 32 0 110 64H384a32 32 0 110-64z"
  }, null, -1);
  const _hoisted_3$38 = [
    _hoisted_2$38
  ];
  function _sfc_render$38(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$38, _hoisted_3$38);
  }
  var dessert = /* @__PURE__ */ _export_sfc(_sfc_main$38, [["render", _sfc_render$38]]);

  const _sfc_main$37 = vue.defineComponent({
    name: "Discount"
  });
  const _hoisted_1$37 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$37 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 704h576V318.336L552.512 115.84a64 64 0 00-81.024 0L224 318.336V704zm0 64v128h576V768H224zM593.024 66.304l259.2 212.096A32 32 0 01864 303.168V928a32 32 0 01-32 32H192a32 32 0 01-32-32V303.168a32 32 0 0111.712-24.768l259.2-212.096a128 128 0 01162.112 0z"
  }, null, -1);
  const _hoisted_3$37 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 448a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256z"
  }, null, -1);
  const _hoisted_4$P = [
    _hoisted_2$37,
    _hoisted_3$37
  ];
  function _sfc_render$37(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$37, _hoisted_4$P);
  }
  var discount = /* @__PURE__ */ _export_sfc(_sfc_main$37, [["render", _sfc_render$37]]);

  const _sfc_main$36 = vue.defineComponent({
    name: "DishDot"
  });
  const _hoisted_1$36 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$36 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384.064 274.56l.064-50.688A128 128 0 01512.128 96c70.528 0 127.68 57.152 127.68 127.68v50.752A448.192 448.192 0 01955.392 768H68.544A448.192 448.192 0 01384 274.56zM96 832h832a32 32 0 110 64H96a32 32 0 110-64zm32-128h768a384 384 0 10-768 0zm447.808-448v-32.32a63.68 63.68 0 00-63.68-63.68 64 64 0 00-64 63.936V256h127.68z"
  }, null, -1);
  const _hoisted_3$36 = [
    _hoisted_2$36
  ];
  function _sfc_render$36(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$36, _hoisted_3$36);
  }
  var dishDot = /* @__PURE__ */ _export_sfc(_sfc_main$36, [["render", _sfc_render$36]]);

  const _sfc_main$35 = vue.defineComponent({
    name: "Dish"
  });
  const _hoisted_1$35 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$35 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 257.152V192h-96a32 32 0 010-64h256a32 32 0 110 64h-96v65.152A448 448 0 01955.52 768H68.48A448 448 0 01480 257.152zM128 704h768a384 384 0 10-768 0zM96 832h832a32 32 0 110 64H96a32 32 0 110-64z"
  }, null, -1);
  const _hoisted_3$35 = [
    _hoisted_2$35
  ];
  function _sfc_render$35(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$35, _hoisted_3$35);
  }
  var dish = /* @__PURE__ */ _export_sfc(_sfc_main$35, [["render", _sfc_render$35]]);

  const _sfc_main$34 = vue.defineComponent({
    name: "DocumentAdd"
  });
  const _hoisted_1$34 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$34 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M832 384H576V128H192v768h640V384zm-26.496-64L640 154.496V320h165.504zM160 64h480l256 256v608a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32zm320 512V448h64v128h128v64H544v128h-64V640H352v-64h128z"
  }, null, -1);
  const _hoisted_3$34 = [
    _hoisted_2$34
  ];
  function _sfc_render$34(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$34, _hoisted_3$34);
  }
  var documentAdd = /* @__PURE__ */ _export_sfc(_sfc_main$34, [["render", _sfc_render$34]]);

  const _sfc_main$33 = vue.defineComponent({
    name: "DocumentChecked"
  });
  const _hoisted_1$33 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$33 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M805.504 320L640 154.496V320h165.504zM832 384H576V128H192v768h640V384zM160 64h480l256 256v608a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32zm318.4 582.144l180.992-180.992L704.64 510.4 478.4 736.64 320 578.304l45.248-45.312L478.4 646.144z"
  }, null, -1);
  const _hoisted_3$33 = [
    _hoisted_2$33
  ];
  function _sfc_render$33(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$33, _hoisted_3$33);
  }
  var documentChecked = /* @__PURE__ */ _export_sfc(_sfc_main$33, [["render", _sfc_render$33]]);

  const _sfc_main$32 = vue.defineComponent({
    name: "DocumentCopy"
  });
  const _hoisted_1$32 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$32 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 320v576h576V320H128zm-32-64h640a32 32 0 0132 32v640a32 32 0 01-32 32H96a32 32 0 01-32-32V288a32 32 0 0132-32zM960 96v704a32 32 0 01-32 32h-96v-64h64V128H384v64h-64V96a32 32 0 0132-32h576a32 32 0 0132 32zM256 672h320v64H256v-64zm0-192h320v64H256v-64z"
  }, null, -1);
  const _hoisted_3$32 = [
    _hoisted_2$32
  ];
  function _sfc_render$32(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$32, _hoisted_3$32);
  }
  var documentCopy = /* @__PURE__ */ _export_sfc(_sfc_main$32, [["render", _sfc_render$32]]);

  const _sfc_main$31 = vue.defineComponent({
    name: "DocumentDelete"
  });
  const _hoisted_1$31 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$31 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M805.504 320L640 154.496V320h165.504zM832 384H576V128H192v768h640V384zM160 64h480l256 256v608a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32zm308.992 546.304l-90.496-90.624 45.248-45.248 90.56 90.496 90.496-90.432 45.248 45.248-90.496 90.56 90.496 90.496-45.248 45.248-90.496-90.496-90.56 90.496-45.248-45.248 90.496-90.496z"
  }, null, -1);
  const _hoisted_3$31 = [
    _hoisted_2$31
  ];
  function _sfc_render$31(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$31, _hoisted_3$31);
  }
  var documentDelete = /* @__PURE__ */ _export_sfc(_sfc_main$31, [["render", _sfc_render$31]]);

  const _sfc_main$30 = vue.defineComponent({
    name: "DocumentRemove"
  });
  const _hoisted_1$30 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$30 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M805.504 320L640 154.496V320h165.504zM832 384H576V128H192v768h640V384zM160 64h480l256 256v608a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32zm192 512h320v64H352v-64z"
  }, null, -1);
  const _hoisted_3$30 = [
    _hoisted_2$30
  ];
  function _sfc_render$30(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$30, _hoisted_3$30);
  }
  var documentRemove = /* @__PURE__ */ _export_sfc(_sfc_main$30, [["render", _sfc_render$30]]);

  const _sfc_main$2$ = vue.defineComponent({
    name: "Document"
  });
  const _hoisted_1$2$ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2$ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M832 384H576V128H192v768h640V384zm-26.496-64L640 154.496V320h165.504zM160 64h480l256 256v608a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32zm160 448h384v64H320v-64zm0-192h160v64H320v-64zm0 384h384v64H320v-64z"
  }, null, -1);
  const _hoisted_3$2$ = [
    _hoisted_2$2$
  ];
  function _sfc_render$2$(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2$, _hoisted_3$2$);
  }
  var document = /* @__PURE__ */ _export_sfc(_sfc_main$2$, [["render", _sfc_render$2$]]);

  const _sfc_main$2_ = vue.defineComponent({
    name: "Download"
  });
  const _hoisted_1$2_ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2_ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 832h704a32 32 0 110 64H160a32 32 0 110-64zm384-253.696l236.288-236.352 45.248 45.248L508.8 704 192 387.2l45.248-45.248L480 584.704V128h64v450.304z"
  }, null, -1);
  const _hoisted_3$2_ = [
    _hoisted_2$2_
  ];
  function _sfc_render$2_(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2_, _hoisted_3$2_);
  }
  var download = /* @__PURE__ */ _export_sfc(_sfc_main$2_, [["render", _sfc_render$2_]]);

  const _sfc_main$2Z = vue.defineComponent({
    name: "Drizzling"
  });
  const _hoisted_1$2Z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2Z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M739.328 291.328l-35.2-6.592-12.8-33.408a192.064 192.064 0 00-365.952 23.232l-9.92 40.896-41.472 7.04a176.32 176.32 0 00-146.24 173.568c0 97.28 78.72 175.936 175.808 175.936h400a192 192 0 0035.776-380.672zM959.552 480a256 256 0 01-256 256h-400A239.808 239.808 0 0163.744 496.192a240.32 240.32 0 01199.488-236.8 256.128 256.128 0 01487.872-30.976A256.064 256.064 0 01959.552 480zM288 800h64v64h-64v-64zm192 0h64v64h-64v-64zm-96 96h64v64h-64v-64zm192 0h64v64h-64v-64zm96-96h64v64h-64v-64z"
  }, null, -1);
  const _hoisted_3$2Z = [
    _hoisted_2$2Z
  ];
  function _sfc_render$2Z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2Z, _hoisted_3$2Z);
  }
  var drizzling = /* @__PURE__ */ _export_sfc(_sfc_main$2Z, [["render", _sfc_render$2Z]]);

  const _sfc_main$2Y = vue.defineComponent({
    name: "Edit"
  });
  const _hoisted_1$2Y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2Y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M832 512a32 32 0 1164 0v352a32 32 0 01-32 32H160a32 32 0 01-32-32V160a32 32 0 0132-32h352a32 32 0 010 64H192v640h640V512z"
  }, null, -1);
  const _hoisted_3$2Y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M469.952 554.24l52.8-7.552L847.104 222.4a32 32 0 10-45.248-45.248L477.44 501.44l-7.552 52.8zm422.4-422.4a96 96 0 010 135.808l-331.84 331.84a32 32 0 01-18.112 9.088L436.8 623.68a32 32 0 01-36.224-36.224l15.104-105.6a32 32 0 019.024-18.112l331.904-331.84a96 96 0 01135.744 0z"
  }, null, -1);
  const _hoisted_4$O = [
    _hoisted_2$2Y,
    _hoisted_3$2Y
  ];
  function _sfc_render$2Y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2Y, _hoisted_4$O);
  }
  var edit = /* @__PURE__ */ _export_sfc(_sfc_main$2Y, [["render", _sfc_render$2Y]]);

  const _sfc_main$2X = vue.defineComponent({
    name: "ElemeFilled"
  });
  const _hoisted_1$2X = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2X = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M176 64h672c61.824 0 112 50.176 112 112v672a112 112 0 01-112 112H176A112 112 0 0164 848V176c0-61.824 50.176-112 112-112zm150.528 173.568c-152.896 99.968-196.544 304.064-97.408 456.96a330.688 330.688 0 00456.96 96.64c9.216-5.888 17.6-11.776 25.152-18.56a18.24 18.24 0 004.224-24.32L700.352 724.8a47.552 47.552 0 00-65.536-14.272A234.56 234.56 0 01310.592 641.6C240 533.248 271.104 387.968 379.456 316.48a234.304 234.304 0 01276.352 15.168c1.664.832 2.56 2.56 3.392 4.224 5.888 8.384 3.328 19.328-5.12 25.216L456.832 489.6a47.552 47.552 0 00-14.336 65.472l16 24.384c5.888 8.384 16.768 10.88 25.216 5.056l308.224-199.936a19.584 19.584 0 006.72-23.488v-.896c-4.992-9.216-10.048-17.6-15.104-26.88-99.968-151.168-304.064-194.88-456.96-95.744zM786.88 504.704l-62.208 40.32c-8.32 5.888-10.88 16.768-4.992 25.216L760 632.32c5.888 8.448 16.768 11.008 25.152 5.12l31.104-20.16a55.36 55.36 0 0016-76.48l-20.224-31.04a19.52 19.52 0 00-25.152-5.12z"
  }, null, -1);
  const _hoisted_3$2X = [
    _hoisted_2$2X
  ];
  function _sfc_render$2X(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2X, _hoisted_3$2X);
  }
  var elemeFilled = /* @__PURE__ */ _export_sfc(_sfc_main$2X, [["render", _sfc_render$2X]]);

  const _sfc_main$2W = vue.defineComponent({
    name: "Eleme"
  });
  const _hoisted_1$2W = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2W = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M300.032 188.8c174.72-113.28 408-63.36 522.24 109.44 5.76 10.56 11.52 20.16 17.28 30.72v.96a22.4 22.4 0 01-7.68 26.88l-352.32 228.48c-9.6 6.72-22.08 3.84-28.8-5.76l-18.24-27.84a54.336 54.336 0 0116.32-74.88l225.6-146.88c9.6-6.72 12.48-19.2 5.76-28.8-.96-1.92-1.92-3.84-3.84-4.8a267.84 267.84 0 00-315.84-17.28c-123.84 81.6-159.36 247.68-78.72 371.52a268.096 268.096 0 00370.56 78.72 54.336 54.336 0 0174.88 16.32l17.28 26.88c5.76 9.6 3.84 21.12-4.8 27.84-8.64 7.68-18.24 14.4-28.8 21.12a377.92 377.92 0 01-522.24-110.4c-113.28-174.72-63.36-408 111.36-522.24zm526.08 305.28a22.336 22.336 0 0128.8 5.76l23.04 35.52a63.232 63.232 0 01-18.24 87.36l-35.52 23.04c-9.6 6.72-22.08 3.84-28.8-5.76l-46.08-71.04c-6.72-9.6-3.84-22.08 5.76-28.8l71.04-46.08z"
  }, null, -1);
  const _hoisted_3$2W = [
    _hoisted_2$2W
  ];
  function _sfc_render$2W(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2W, _hoisted_3$2W);
  }
  var eleme = /* @__PURE__ */ _export_sfc(_sfc_main$2W, [["render", _sfc_render$2W]]);

  const _sfc_main$2V = vue.defineComponent({
    name: "Expand"
  });
  const _hoisted_1$2V = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2V = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 192h768v128H128V192zm0 256h512v128H128V448zm0 256h768v128H128V704zm576-352l192 160-192 128V352z"
  }, null, -1);
  const _hoisted_3$2V = [
    _hoisted_2$2V
  ];
  function _sfc_render$2V(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2V, _hoisted_3$2V);
  }
  var expand = /* @__PURE__ */ _export_sfc(_sfc_main$2V, [["render", _sfc_render$2V]]);

  const _sfc_main$2U = vue.defineComponent({
    name: "Failed"
  });
  const _hoisted_1$2U = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2U = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M557.248 608l135.744-135.744-45.248-45.248-135.68 135.744-135.808-135.68-45.248 45.184L466.752 608l-135.68 135.68 45.184 45.312L512 653.248l135.744 135.744 45.248-45.248L557.312 608zM704 192h160v736H160V192h160v64h384v-64zm-320 0V96h256v96H384z"
  }, null, -1);
  const _hoisted_3$2U = [
    _hoisted_2$2U
  ];
  function _sfc_render$2U(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2U, _hoisted_3$2U);
  }
  var failed = /* @__PURE__ */ _export_sfc(_sfc_main$2U, [["render", _sfc_render$2U]]);

  const _sfc_main$2T = vue.defineComponent({
    name: "Female"
  });
  const _hoisted_1$2T = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2T = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 640a256 256 0 100-512 256 256 0 000 512zm0 64a320 320 0 110-640 320 320 0 010 640z"
  }, null, -1);
  const _hoisted_3$2T = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 640q32 0 32 32v256q0 32-32 32t-32-32V672q0-32 32-32z"
  }, null, -1);
  const _hoisted_4$N = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 800h320q32 0 32 32t-32 32H352q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_5$c = [
    _hoisted_2$2T,
    _hoisted_3$2T,
    _hoisted_4$N
  ];
  function _sfc_render$2T(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2T, _hoisted_5$c);
  }
  var female = /* @__PURE__ */ _export_sfc(_sfc_main$2T, [["render", _sfc_render$2T]]);

  const _sfc_main$2S = vue.defineComponent({
    name: "Files"
  });
  const _hoisted_1$2S = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2S = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 384v448h768V384H128zm-32-64h832a32 32 0 0132 32v512a32 32 0 01-32 32H96a32 32 0 01-32-32V352a32 32 0 0132-32zM160 192h704v64H160zm96-128h512v64H256z"
  }, null, -1);
  const _hoisted_3$2S = [
    _hoisted_2$2S
  ];
  function _sfc_render$2S(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2S, _hoisted_3$2S);
  }
  var files = /* @__PURE__ */ _export_sfc(_sfc_main$2S, [["render", _sfc_render$2S]]);

  const _sfc_main$2R = vue.defineComponent({
    name: "Film"
  });
  const _hoisted_1$2R = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 160v704h704V160H160zm-32-64h768a32 32 0 0132 32v768a32 32 0 01-32 32H128a32 32 0 01-32-32V128a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$2R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M320 288V128h64v352h256V128h64v160h160v64H704v128h160v64H704v128h160v64H704v160h-64V544H384v352h-64V736H128v-64h192V544H128v-64h192V352H128v-64h192z"
  }, null, -1);
  const _hoisted_4$M = [
    _hoisted_2$2R,
    _hoisted_3$2R
  ];
  function _sfc_render$2R(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2R, _hoisted_4$M);
  }
  var film = /* @__PURE__ */ _export_sfc(_sfc_main$2R, [["render", _sfc_render$2R]]);

  const _sfc_main$2Q = vue.defineComponent({
    name: "Filter"
  });
  const _hoisted_1$2Q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2Q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 523.392V928a32 32 0 0046.336 28.608l192-96A32 32 0 00640 832V523.392l280.768-343.104a32 32 0 10-49.536-40.576l-288 352A32 32 0 00576 512v300.224l-128 64V512a32 32 0 00-7.232-20.288L195.52 192H704a32 32 0 100-64H128a32 32 0 00-24.768 52.288L384 523.392z"
  }, null, -1);
  const _hoisted_3$2Q = [
    _hoisted_2$2Q
  ];
  function _sfc_render$2Q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2Q, _hoisted_3$2Q);
  }
  var filter = /* @__PURE__ */ _export_sfc(_sfc_main$2Q, [["render", _sfc_render$2Q]]);

  const _sfc_main$2P = vue.defineComponent({
    name: "Finished"
  });
  const _hoisted_1$2P = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2P = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M280.768 753.728L691.456 167.04a32 32 0 1152.416 36.672L314.24 817.472a32 32 0 01-45.44 7.296l-230.4-172.8a32 32 0 0138.4-51.2l203.968 152.96zM736 448a32 32 0 110-64h192a32 32 0 110 64H736zM608 640a32 32 0 010-64h319.936a32 32 0 110 64H608zM480 832a32 32 0 110-64h447.936a32 32 0 110 64H480z"
  }, null, -1);
  const _hoisted_3$2P = [
    _hoisted_2$2P
  ];
  function _sfc_render$2P(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2P, _hoisted_3$2P);
  }
  var finished = /* @__PURE__ */ _export_sfc(_sfc_main$2P, [["render", _sfc_render$2P]]);

  const _sfc_main$2O = vue.defineComponent({
    name: "FirstAidKit"
  });
  const _hoisted_1$2O = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 256a64 64 0 00-64 64v448a64 64 0 0064 64h640a64 64 0 0064-64V320a64 64 0 00-64-64H192zm0-64h640a128 128 0 01128 128v448a128 128 0 01-128 128H192A128 128 0 0164 768V320a128 128 0 01128-128z"
  }, null, -1);
  const _hoisted_3$2O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 512h96a32 32 0 010 64h-96v96a32 32 0 01-64 0v-96h-96a32 32 0 010-64h96v-96a32 32 0 0164 0v96zM352 128v64h320v-64H352zm-32-64h384a32 32 0 0132 32v128a32 32 0 01-32 32H320a32 32 0 01-32-32V96a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4$L = [
    _hoisted_2$2O,
    _hoisted_3$2O
  ];
  function _sfc_render$2O(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2O, _hoisted_4$L);
  }
  var firstAidKit = /* @__PURE__ */ _export_sfc(_sfc_main$2O, [["render", _sfc_render$2O]]);

  const _sfc_main$2N = vue.defineComponent({
    name: "Flag"
  });
  const _hoisted_1$2N = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2N = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 128h608L736 384l160 256H288v320h-96V64h96v64z"
  }, null, -1);
  const _hoisted_3$2N = [
    _hoisted_2$2N
  ];
  function _sfc_render$2N(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2N, _hoisted_3$2N);
  }
  var flag = /* @__PURE__ */ _export_sfc(_sfc_main$2N, [["render", _sfc_render$2N]]);

  const _sfc_main$2M = vue.defineComponent({
    name: "Fold"
  });
  const _hoisted_1$2M = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2M = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M896 192H128v128h768V192zm0 256H384v128h512V448zm0 256H128v128h768V704zM320 384L128 512l192 128V384z"
  }, null, -1);
  const _hoisted_3$2M = [
    _hoisted_2$2M
  ];
  function _sfc_render$2M(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2M, _hoisted_3$2M);
  }
  var fold = /* @__PURE__ */ _export_sfc(_sfc_main$2M, [["render", _sfc_render$2M]]);

  const _sfc_main$2L = vue.defineComponent({
    name: "FolderAdd"
  });
  const _hoisted_1$2L = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2L = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 192v640h768V320H485.76L357.504 192H128zm-32-64h287.872l128.384 128H928a32 32 0 0132 32v576a32 32 0 01-32 32H96a32 32 0 01-32-32V160a32 32 0 0132-32zm384 416V416h64v128h128v64H544v128h-64V608H352v-64h128z"
  }, null, -1);
  const _hoisted_3$2L = [
    _hoisted_2$2L
  ];
  function _sfc_render$2L(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2L, _hoisted_3$2L);
  }
  var folderAdd = /* @__PURE__ */ _export_sfc(_sfc_main$2L, [["render", _sfc_render$2L]]);

  const _sfc_main$2K = vue.defineComponent({
    name: "FolderChecked"
  });
  const _hoisted_1$2K = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2K = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 192v640h768V320H485.76L357.504 192H128zm-32-64h287.872l128.384 128H928a32 32 0 0132 32v576a32 32 0 01-32 32H96a32 32 0 01-32-32V160a32 32 0 0132-32zm414.08 502.144l180.992-180.992L736.32 494.4 510.08 720.64l-158.4-158.336 45.248-45.312L510.08 630.144z"
  }, null, -1);
  const _hoisted_3$2K = [
    _hoisted_2$2K
  ];
  function _sfc_render$2K(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2K, _hoisted_3$2K);
  }
  var folderChecked = /* @__PURE__ */ _export_sfc(_sfc_main$2K, [["render", _sfc_render$2K]]);

  const _sfc_main$2J = vue.defineComponent({
    name: "FolderDelete"
  });
  const _hoisted_1$2J = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2J = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 192v640h768V320H485.76L357.504 192H128zm-32-64h287.872l128.384 128H928a32 32 0 0132 32v576a32 32 0 01-32 32H96a32 32 0 01-32-32V160a32 32 0 0132-32zm370.752 448l-90.496-90.496 45.248-45.248L512 530.752l90.496-90.496 45.248 45.248L557.248 576l90.496 90.496-45.248 45.248L512 621.248l-90.496 90.496-45.248-45.248L466.752 576z"
  }, null, -1);
  const _hoisted_3$2J = [
    _hoisted_2$2J
  ];
  function _sfc_render$2J(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2J, _hoisted_3$2J);
  }
  var folderDelete = /* @__PURE__ */ _export_sfc(_sfc_main$2J, [["render", _sfc_render$2J]]);

  const _sfc_main$2I = vue.defineComponent({
    name: "FolderOpened"
  });
  const _hoisted_1$2I = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2I = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M878.08 448H241.92l-96 384h636.16l96-384zM832 384v-64H485.76L357.504 192H128v448l57.92-231.744A32 32 0 01216.96 384H832zm-24.96 512H96a32 32 0 01-32-32V160a32 32 0 0132-32h287.872l128.384 128H864a32 32 0 0132 32v96h23.04a32 32 0 0131.04 39.744l-112 448A32 32 0 01807.04 896z"
  }, null, -1);
  const _hoisted_3$2I = [
    _hoisted_2$2I
  ];
  function _sfc_render$2I(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2I, _hoisted_3$2I);
  }
  var folderOpened = /* @__PURE__ */ _export_sfc(_sfc_main$2I, [["render", _sfc_render$2I]]);

  const _sfc_main$2H = vue.defineComponent({
    name: "FolderRemove"
  });
  const _hoisted_1$2H = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2H = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 192v640h768V320H485.76L357.504 192H128zm-32-64h287.872l128.384 128H928a32 32 0 0132 32v576a32 32 0 01-32 32H96a32 32 0 01-32-32V160a32 32 0 0132-32zm256 416h320v64H352v-64z"
  }, null, -1);
  const _hoisted_3$2H = [
    _hoisted_2$2H
  ];
  function _sfc_render$2H(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2H, _hoisted_3$2H);
  }
  var folderRemove = /* @__PURE__ */ _export_sfc(_sfc_main$2H, [["render", _sfc_render$2H]]);

  const _sfc_main$2G = vue.defineComponent({
    name: "Folder"
  });
  const _hoisted_1$2G = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2G = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 192v640h768V320H485.76L357.504 192H128zm-32-64h287.872l128.384 128H928a32 32 0 0132 32v576a32 32 0 01-32 32H96a32 32 0 01-32-32V160a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$2G = [
    _hoisted_2$2G
  ];
  function _sfc_render$2G(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2G, _hoisted_3$2G);
  }
  var folder = /* @__PURE__ */ _export_sfc(_sfc_main$2G, [["render", _sfc_render$2G]]);

  const _sfc_main$2F = vue.defineComponent({
    name: "Food"
  });
  const _hoisted_1$2F = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2F = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 352.576V352a288 288 0 01491.072-204.224 192 192 0 01274.24 204.48 64 64 0 0157.216 74.24C921.6 600.512 850.048 710.656 736 756.992V800a96 96 0 01-96 96H384a96 96 0 01-96-96v-43.008c-114.048-46.336-185.6-156.48-214.528-330.496A64 64 0 01128 352.64zm64-.576h64a160 160 0 01320 0h64a224 224 0 00-448 0zm128 0h192a96 96 0 00-192 0zm439.424 0h68.544A128.256 128.256 0 00704 192c-15.36 0-29.952 2.688-43.52 7.616 11.328 18.176 20.672 37.76 27.84 58.304A64.128 64.128 0 01759.424 352zM672 768H352v32a32 32 0 0032 32h256a32 32 0 0032-32v-32zm-342.528-64h365.056c101.504-32.64 165.76-124.928 192.896-288H136.576c27.136 163.072 91.392 255.36 192.896 288z"
  }, null, -1);
  const _hoisted_3$2F = [
    _hoisted_2$2F
  ];
  function _sfc_render$2F(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2F, _hoisted_3$2F);
  }
  var food = /* @__PURE__ */ _export_sfc(_sfc_main$2F, [["render", _sfc_render$2F]]);

  const _sfc_main$2E = vue.defineComponent({
    name: "Football"
  });
  const _hoisted_1$2E = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 960a448 448 0 110-896 448 448 0 010 896zm0-64a384 384 0 100-768 384 384 0 000 768z"
  }, null, -1);
  const _hoisted_3$2E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M186.816 268.288c16-16.384 31.616-31.744 46.976-46.08 17.472 30.656 39.808 58.112 65.984 81.28l-32.512 56.448a385.984 385.984 0 01-80.448-91.648zm653.696-5.312a385.92 385.92 0 01-83.776 96.96l-32.512-56.384a322.923 322.923 0 0068.48-85.76c15.552 14.08 31.488 29.12 47.808 45.184zM465.984 445.248l11.136-63.104a323.584 323.584 0 0069.76 0l11.136 63.104a387.968 387.968 0 01-92.032 0zm-62.72-12.8A381.824 381.824 0 01320 396.544l32-55.424a319.885 319.885 0 0062.464 27.712l-11.2 63.488zm300.8-35.84a381.824 381.824 0 01-83.328 35.84l-11.2-63.552A319.885 319.885 0 00672 341.184l32 55.424zm-520.768 364.8a385.92 385.92 0 0183.968-97.28l32.512 56.32c-26.88 23.936-49.856 52.352-67.52 84.032-16-13.44-32.32-27.712-48.96-43.072zm657.536.128a1442.759 1442.759 0 01-49.024 43.072 321.408 321.408 0 00-67.584-84.16l32.512-56.32c33.216 27.456 61.696 60.352 84.096 97.408zM465.92 578.752a387.968 387.968 0 0192.032 0l-11.136 63.104a323.584 323.584 0 00-69.76 0l-11.136-63.104zm-62.72 12.8l11.2 63.552a319.885 319.885 0 00-62.464 27.712L320 627.392a381.824 381.824 0 0183.264-35.84zm300.8 35.84l-32 55.424a318.272 318.272 0 00-62.528-27.712l11.2-63.488c29.44 8.64 57.28 20.736 83.264 35.776z"
  }, null, -1);
  const _hoisted_4$K = [
    _hoisted_2$2E,
    _hoisted_3$2E
  ];
  function _sfc_render$2E(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2E, _hoisted_4$K);
  }
  var football = /* @__PURE__ */ _export_sfc(_sfc_main$2E, [["render", _sfc_render$2E]]);

  const _sfc_main$2D = vue.defineComponent({
    name: "ForkSpoon"
  });
  const _hoisted_1$2D = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2D = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 410.304V96a32 32 0 0164 0v314.304a96 96 0 0064-90.56V96a32 32 0 0164 0v223.744a160 160 0 01-128 156.8V928a32 32 0 11-64 0V476.544a160 160 0 01-128-156.8V96a32 32 0 0164 0v223.744a96 96 0 0064 90.56zM672 572.48C581.184 552.128 512 446.848 512 320c0-141.44 85.952-256 192-256s192 114.56 192 256c0 126.848-69.184 232.128-160 252.48V928a32 32 0 11-64 0V572.48zM704 512c66.048 0 128-82.56 128-192s-61.952-192-128-192-128 82.56-128 192 61.952 192 128 192z"
  }, null, -1);
  const _hoisted_3$2D = [
    _hoisted_2$2D
  ];
  function _sfc_render$2D(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2D, _hoisted_3$2D);
  }
  var forkSpoon = /* @__PURE__ */ _export_sfc(_sfc_main$2D, [["render", _sfc_render$2D]]);

  const _sfc_main$2C = vue.defineComponent({
    name: "Fries"
  });
  const _hoisted_1$2C = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M608 224v-64a32 32 0 00-64 0v336h26.88A64 64 0 00608 484.096V224zm101.12 160A64 64 0 00672 395.904V384h64V224a32 32 0 10-64 0v160h37.12zm74.88 0a92.928 92.928 0 0191.328 110.08l-60.672 323.584A96 96 0 01720.32 896H303.68a96 96 0 01-94.336-78.336L148.672 494.08A92.928 92.928 0 01240 384h-16V224a96 96 0 01188.608-25.28A95.744 95.744 0 01480 197.44V160a96 96 0 01188.608-25.28A96 96 0 01800 224v160h-16zM670.784 512a128 128 0 01-99.904 48H453.12a128 128 0 01-99.84-48H352v-1.536a128.128 128.128 0 01-9.984-14.976L314.88 448H240a28.928 28.928 0 00-28.48 34.304L241.088 640h541.824l29.568-157.696A28.928 28.928 0 00784 448h-74.88l-27.136 47.488A132.405 132.405 0 01672 510.464V512h-1.216zM480 288a32 32 0 00-64 0v196.096A64 64 0 00453.12 496H480V288zm-128 96V224a32 32 0 00-64 0v160h64-37.12A64 64 0 01352 395.904zm-98.88 320l19.072 101.888A32 32 0 00303.68 832h416.64a32 32 0 0031.488-26.112L770.88 704H253.12z"
  }, null, -1);
  const _hoisted_3$2C = [
    _hoisted_2$2C
  ];
  function _sfc_render$2C(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2C, _hoisted_3$2C);
  }
  var fries = /* @__PURE__ */ _export_sfc(_sfc_main$2C, [["render", _sfc_render$2C]]);

  const _sfc_main$2B = vue.defineComponent({
    name: "FullScreen"
  });
  const _hoisted_1$2B = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2B = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 96.064l192 .192a32 32 0 010 64l-192-.192V352a32 32 0 01-64 0V96h64v.064zm0 831.872V928H96V672a32 32 0 1164 0v191.936l192-.192a32 32 0 110 64l-192 .192zM864 96.064V96h64v256a32 32 0 11-64 0V160.064l-192 .192a32 32 0 110-64l192-.192zm0 831.872l-192-.192a32 32 0 010-64l192 .192V672a32 32 0 1164 0v256h-64v-.064z"
  }, null, -1);
  const _hoisted_3$2B = [
    _hoisted_2$2B
  ];
  function _sfc_render$2B(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2B, _hoisted_3$2B);
  }
  var fullScreen = /* @__PURE__ */ _export_sfc(_sfc_main$2B, [["render", _sfc_render$2B]]);

  const _sfc_main$2A = vue.defineComponent({
    name: "GobletFull"
  });
  const _hoisted_1$2A = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2A = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 320h512c0-78.592-12.608-142.4-36.928-192h-434.24C269.504 192.384 256 256.256 256 320zm503.936 64H264.064a256.128 256.128 0 00495.872 0zM544 638.4V896h96a32 32 0 110 64H384a32 32 0 110-64h96V638.4A320 320 0 01192 320c0-85.632 21.312-170.944 64-256h512c42.688 64.32 64 149.632 64 256a320 320 0 01-288 318.4z"
  }, null, -1);
  const _hoisted_3$2A = [
    _hoisted_2$2A
  ];
  function _sfc_render$2A(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2A, _hoisted_3$2A);
  }
  var gobletFull = /* @__PURE__ */ _export_sfc(_sfc_main$2A, [["render", _sfc_render$2A]]);

  const _sfc_main$2z = vue.defineComponent({
    name: "GobletSquareFull"
  });
  const _hoisted_1$2z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 270.912c10.048 6.72 22.464 14.912 28.992 18.624a220.16 220.16 0 00114.752 30.72c30.592 0 49.408-9.472 91.072-41.152l.64-.448c52.928-40.32 82.368-55.04 132.288-54.656 55.552.448 99.584 20.8 142.72 57.408l1.536 1.28V128H256v142.912zm.96 76.288C266.368 482.176 346.88 575.872 512 576c157.44.064 237.952-85.056 253.248-209.984a952.32 952.32 0 01-40.192-35.712c-32.704-27.776-63.36-41.92-101.888-42.24-31.552-.256-50.624 9.28-93.12 41.6l-.576.448c-52.096 39.616-81.024 54.208-129.792 54.208-54.784 0-100.48-13.376-142.784-37.056zM480 638.848C250.624 623.424 192 442.496 192 319.68V96a32 32 0 0132-32h576a32 32 0 0132 32v224c0 122.816-58.624 303.68-288 318.912V896h96a32 32 0 110 64H384a32 32 0 110-64h96V638.848z"
  }, null, -1);
  const _hoisted_3$2z = [
    _hoisted_2$2z
  ];
  function _sfc_render$2z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2z, _hoisted_3$2z);
  }
  var gobletSquareFull = /* @__PURE__ */ _export_sfc(_sfc_main$2z, [["render", _sfc_render$2z]]);

  const _sfc_main$2y = vue.defineComponent({
    name: "GobletSquare"
  });
  const _hoisted_1$2y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 638.912V896h96a32 32 0 110 64H384a32 32 0 110-64h96V638.848C250.624 623.424 192 442.496 192 319.68V96a32 32 0 0132-32h576a32 32 0 0132 32v224c0 122.816-58.624 303.68-288 318.912zM256 319.68c0 149.568 80 256.192 256 256.256C688.128 576 768 469.568 768 320V128H256v191.68z"
  }, null, -1);
  const _hoisted_3$2y = [
    _hoisted_2$2y
  ];
  function _sfc_render$2y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2y, _hoisted_3$2y);
  }
  var gobletSquare = /* @__PURE__ */ _export_sfc(_sfc_main$2y, [["render", _sfc_render$2y]]);

  const _sfc_main$2x = vue.defineComponent({
    name: "Goblet"
  });
  const _hoisted_1$2x = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2x = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 638.4V896h96a32 32 0 110 64H384a32 32 0 110-64h96V638.4A320 320 0 01192 320c0-85.632 21.312-170.944 64-256h512c42.688 64.32 64 149.632 64 256a320 320 0 01-288 318.4zM256 320a256 256 0 10512 0c0-78.592-12.608-142.4-36.928-192h-434.24C269.504 192.384 256 256.256 256 320z"
  }, null, -1);
  const _hoisted_3$2x = [
    _hoisted_2$2x
  ];
  function _sfc_render$2x(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2x, _hoisted_3$2x);
  }
  var goblet = /* @__PURE__ */ _export_sfc(_sfc_main$2x, [["render", _sfc_render$2x]]);

  const _sfc_main$2w = vue.defineComponent({
    name: "GoodsFilled"
  });
  const _hoisted_1$2w = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2w = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 352h640l64 544H128l64-544zm128 224h64V448h-64v128zm320 0h64V448h-64v128zM384 288h-64a192 192 0 11384 0h-64a128 128 0 10-256 0z"
  }, null, -1);
  const _hoisted_3$2w = [
    _hoisted_2$2w
  ];
  function _sfc_render$2w(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2w, _hoisted_3$2w);
  }
  var goodsFilled = /* @__PURE__ */ _export_sfc(_sfc_main$2w, [["render", _sfc_render$2w]]);

  const _sfc_main$2v = vue.defineComponent({
    name: "Goods"
  });
  const _hoisted_1$2v = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2v = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M320 288v-22.336C320 154.688 405.504 64 512 64s192 90.688 192 201.664v22.4h131.072a32 32 0 0131.808 28.8l57.6 576a32 32 0 01-31.808 35.2H131.328a32 32 0 01-31.808-35.2l57.6-576a32 32 0 0131.808-28.8H320zm64 0h256v-22.336C640 189.248 582.272 128 512 128c-70.272 0-128 61.248-128 137.664v22.4zm-64 64H217.92l-51.2 512h690.56l-51.264-512H704v96a32 32 0 11-64 0v-96H384v96a32 32 0 01-64 0v-96z"
  }, null, -1);
  const _hoisted_3$2v = [
    _hoisted_2$2v
  ];
  function _sfc_render$2v(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2v, _hoisted_3$2v);
  }
  var goods = /* @__PURE__ */ _export_sfc(_sfc_main$2v, [["render", _sfc_render$2v]]);

  const _sfc_main$2u = vue.defineComponent({
    name: "Grape"
  });
  const _hoisted_1$2u = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2u = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 195.2a160 160 0 0196 60.8 160 160 0 11146.24 254.976 160 160 0 01-128 224 160 160 0 11-292.48 0 160 160 0 01-128-224A160 160 0 11384 256a160 160 0 0196-60.8V128h-64a32 32 0 010-64h192a32 32 0 010 64h-64v67.2zM512 448a96 96 0 100-192 96 96 0 000 192zm-256 0a96 96 0 100-192 96 96 0 000 192zm128 224a96 96 0 100-192 96 96 0 000 192zm128 224a96 96 0 100-192 96 96 0 000 192zm128-224a96 96 0 100-192 96 96 0 000 192zm128-224a96 96 0 100-192 96 96 0 000 192z"
  }, null, -1);
  const _hoisted_3$2u = [
    _hoisted_2$2u
  ];
  function _sfc_render$2u(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2u, _hoisted_3$2u);
  }
  var grape = /* @__PURE__ */ _export_sfc(_sfc_main$2u, [["render", _sfc_render$2u]]);

  const _sfc_main$2t = vue.defineComponent({
    name: "Grid"
  });
  const _hoisted_1$2t = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 384v256H384V384h256zm64 0h192v256H704V384zm-64 512H384V704h256v192zm64 0V704h192v192H704zm-64-768v192H384V128h256zm64 0h192v192H704V128zM320 384v256H128V384h192zm0 512H128V704h192v192zm0-768v192H128V128h192z"
  }, null, -1);
  const _hoisted_3$2t = [
    _hoisted_2$2t
  ];
  function _sfc_render$2t(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2t, _hoisted_3$2t);
  }
  var grid = /* @__PURE__ */ _export_sfc(_sfc_main$2t, [["render", _sfc_render$2t]]);

  const _sfc_main$2s = vue.defineComponent({
    name: "Guide"
  });
  const _hoisted_1$2s = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 608h-64V416h64v192zm0 160v160a32 32 0 01-32 32H416a32 32 0 01-32-32V768h64v128h128V768h64zM384 608V416h64v192h-64zm256-352h-64V128H448v128h-64V96a32 32 0 0132-32h192a32 32 0 0132 32v160z"
  }, null, -1);
  const _hoisted_3$2s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M220.8 256l-71.232 80 71.168 80H768V256H220.8zm-14.4-64H800a32 32 0 0132 32v224a32 32 0 01-32 32H206.4a32 32 0 01-23.936-10.752l-99.584-112a32 32 0 010-42.496l99.584-112A32 32 0 01206.4 192zm678.784 496l-71.104 80H266.816V608h547.2l71.168 80zm-56.768-144H234.88a32 32 0 00-32 32v224a32 32 0 0032 32h593.6a32 32 0 0023.936-10.752l99.584-112a32 32 0 000-42.496l-99.584-112A32 32 0 00828.48 544z"
  }, null, -1);
  const _hoisted_4$J = [
    _hoisted_2$2s,
    _hoisted_3$2s
  ];
  function _sfc_render$2s(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2s, _hoisted_4$J);
  }
  var guide = /* @__PURE__ */ _export_sfc(_sfc_main$2s, [["render", _sfc_render$2s]]);

  const _sfc_main$2r = vue.defineComponent({
    name: "Headset"
  });
  const _hoisted_1$2r = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2r = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M896 529.152V512a384 384 0 10-768 0v17.152A128 128 0 01320 640v128a128 128 0 11-256 0V512a448 448 0 11896 0v256a128 128 0 11-256 0V640a128 128 0 01192-110.848zM896 640a64 64 0 00-128 0v128a64 64 0 00128 0V640zm-768 0v128a64 64 0 00128 0V640a64 64 0 10-128 0z"
  }, null, -1);
  const _hoisted_3$2r = [
    _hoisted_2$2r
  ];
  function _sfc_render$2r(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2r, _hoisted_3$2r);
  }
  var headset = /* @__PURE__ */ _export_sfc(_sfc_main$2r, [["render", _sfc_render$2r]]);

  const _sfc_main$2q = vue.defineComponent({
    name: "HelpFilled"
  });
  const _hoisted_1$2q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M926.784 480H701.312A192.512 192.512 0 00544 322.688V97.216A416.064 416.064 0 01926.784 480zm0 64A416.064 416.064 0 01544 926.784V701.312A192.512 192.512 0 00701.312 544h225.472zM97.28 544h225.472A192.512 192.512 0 00480 701.312v225.472A416.064 416.064 0 0197.216 544zm0-64A416.064 416.064 0 01480 97.216v225.472A192.512 192.512 0 00322.688 480H97.216z"
  }, null, -1);
  const _hoisted_3$2q = [
    _hoisted_2$2q
  ];
  function _sfc_render$2q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2q, _hoisted_3$2q);
  }
  var helpFilled = /* @__PURE__ */ _export_sfc(_sfc_main$2q, [["render", _sfc_render$2q]]);

  const _sfc_main$2p = vue.defineComponent({
    name: "Help"
  });
  const _hoisted_1$2p = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2p = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M759.936 805.248l-90.944-91.008A254.912 254.912 0 01512 768a254.912 254.912 0 01-156.992-53.76l-90.944 91.008A382.464 382.464 0 00512 896c94.528 0 181.12-34.176 247.936-90.752zm45.312-45.312A382.464 382.464 0 00896 512c0-94.528-34.176-181.12-90.752-247.936l-91.008 90.944C747.904 398.4 768 452.864 768 512c0 59.136-20.096 113.6-53.76 156.992l91.008 90.944zm-45.312-541.184A382.464 382.464 0 00512 128c-94.528 0-181.12 34.176-247.936 90.752l90.944 91.008A254.912 254.912 0 01512 256c59.136 0 113.6 20.096 156.992 53.76l90.944-91.008zm-541.184 45.312A382.464 382.464 0 00128 512c0 94.528 34.176 181.12 90.752 247.936l91.008-90.944A254.912 254.912 0 01256 512c0-59.136 20.096-113.6 53.76-156.992l-91.008-90.944zm417.28 394.496a194.56 194.56 0 0022.528-22.528C686.912 602.56 704 559.232 704 512a191.232 191.232 0 00-67.968-146.56A191.296 191.296 0 00512 320a191.232 191.232 0 00-146.56 67.968C337.088 421.44 320 464.768 320 512a191.232 191.232 0 0067.968 146.56C421.44 686.912 464.768 704 512 704c47.296 0 90.56-17.088 124.032-45.44zM512 960a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$2p = [
    _hoisted_2$2p
  ];
  function _sfc_render$2p(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2p, _hoisted_3$2p);
  }
  var help = /* @__PURE__ */ _export_sfc(_sfc_main$2p, [["render", _sfc_render$2p]]);

  const _sfc_main$2o = vue.defineComponent({
    name: "Histogram"
  });
  const _hoisted_1$2o = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2o = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M416 896V128h192v768H416zm-288 0V448h192v448H128zm576 0V320h192v576H704z"
  }, null, -1);
  const _hoisted_3$2o = [
    _hoisted_2$2o
  ];
  function _sfc_render$2o(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2o, _hoisted_3$2o);
  }
  var histogram = /* @__PURE__ */ _export_sfc(_sfc_main$2o, [["render", _sfc_render$2o]]);

  const _sfc_main$2n = vue.defineComponent({
    name: "HomeFilled"
  });
  const _hoisted_1$2n = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2n = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 128L128 447.936V896h255.936V640H640v256h255.936V447.936z"
  }, null, -1);
  const _hoisted_3$2n = [
    _hoisted_2$2n
  ];
  function _sfc_render$2n(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2n, _hoisted_3$2n);
  }
  var homeFilled = /* @__PURE__ */ _export_sfc(_sfc_main$2n, [["render", _sfc_render$2n]]);

  const _sfc_main$2m = vue.defineComponent({
    name: "HotWater"
  });
  const _hoisted_1$2m = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M273.067 477.867h477.866V409.6H273.067v68.267zm0 68.266v51.2A187.733 187.733 0 00460.8 785.067h102.4a187.733 187.733 0 00187.733-187.734v-51.2H273.067zm-34.134-204.8h546.134a34.133 34.133 0 0134.133 34.134v221.866a256 256 0 01-256 256H460.8a256 256 0 01-256-256V375.467a34.133 34.133 0 0134.133-34.134zM512 34.133a34.133 34.133 0 0134.133 34.134v170.666a34.133 34.133 0 01-68.266 0V68.267A34.133 34.133 0 01512 34.133zM375.467 102.4a34.133 34.133 0 0134.133 34.133v102.4a34.133 34.133 0 01-68.267 0v-102.4a34.133 34.133 0 0134.134-34.133zm273.066 0a34.133 34.133 0 0134.134 34.133v102.4a34.133 34.133 0 11-68.267 0v-102.4a34.133 34.133 0 0134.133-34.133zM170.667 921.668h682.666a34.133 34.133 0 110 68.267H170.667a34.133 34.133 0 110-68.267z"
  }, null, -1);
  const _hoisted_3$2m = [
    _hoisted_2$2m
  ];
  function _sfc_render$2m(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2m, _hoisted_3$2m);
  }
  var hotWater = /* @__PURE__ */ _export_sfc(_sfc_main$2m, [["render", _sfc_render$2m]]);

  const _sfc_main$2l = vue.defineComponent({
    name: "House"
  });
  const _hoisted_1$2l = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 413.952V896h640V413.952L512 147.328 192 413.952zM139.52 374.4l352-293.312a32 32 0 0140.96 0l352 293.312A32 32 0 01896 398.976V928a32 32 0 01-32 32H160a32 32 0 01-32-32V398.976a32 32 0 0111.52-24.576z"
  }, null, -1);
  const _hoisted_3$2l = [
    _hoisted_2$2l
  ];
  function _sfc_render$2l(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2l, _hoisted_3$2l);
  }
  var house = /* @__PURE__ */ _export_sfc(_sfc_main$2l, [["render", _sfc_render$2l]]);

  const _sfc_main$2k = vue.defineComponent({
    name: "IceCreamRound"
  });
  const _hoisted_1$2k = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M308.352 489.344l226.304 226.304a32 32 0 0045.248 0L783.552 512A192 192 0 10512 240.448L308.352 444.16a32 32 0 000 45.248zm135.744 226.304L308.352 851.392a96 96 0 01-135.744-135.744l135.744-135.744-45.248-45.248a96 96 0 010-135.808L466.752 195.2A256 256 0 01828.8 557.248L625.152 760.96a96 96 0 01-135.808 0l-45.248-45.248zM398.848 670.4L353.6 625.152 217.856 760.896a32 32 0 0045.248 45.248L398.848 670.4zm248.96-384.64a32 32 0 010 45.248L466.624 512a32 32 0 11-45.184-45.248l180.992-181.056a32 32 0 0145.248 0zm90.496 90.496a32 32 0 010 45.248L557.248 602.496A32 32 0 11512 557.248l180.992-180.992a32 32 0 0145.312 0z"
  }, null, -1);
  const _hoisted_3$2k = [
    _hoisted_2$2k
  ];
  function _sfc_render$2k(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2k, _hoisted_3$2k);
  }
  var iceCreamRound = /* @__PURE__ */ _export_sfc(_sfc_main$2k, [["render", _sfc_render$2k]]);

  const _sfc_main$2j = vue.defineComponent({
    name: "IceCreamSquare"
  });
  const _hoisted_1$2j = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M416 640h256a32 32 0 0032-32V160a32 32 0 00-32-32H352a32 32 0 00-32 32v448a32 32 0 0032 32h64zm192 64v160a96 96 0 01-192 0V704h-64a96 96 0 01-96-96V160a96 96 0 0196-96h320a96 96 0 0196 96v448a96 96 0 01-96 96h-64zm-64 0h-64v160a32 32 0 1064 0V704z"
  }, null, -1);
  const _hoisted_3$2j = [
    _hoisted_2$2j
  ];
  function _sfc_render$2j(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2j, _hoisted_3$2j);
  }
  var iceCreamSquare = /* @__PURE__ */ _export_sfc(_sfc_main$2j, [["render", _sfc_render$2j]]);

  const _sfc_main$2i = vue.defineComponent({
    name: "IceCream"
  });
  const _hoisted_1$2i = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2i = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128.64 448a208 208 0 01193.536-191.552 224 224 0 01445.248 15.488A208.128 208.128 0 01894.784 448H896L548.8 983.68a32 32 0 01-53.248.704L128 448h.64zm64.256 0h286.208a144 144 0 00-286.208 0zm351.36 0h286.272a144 144 0 00-286.272 0zm-294.848 64l271.808 396.608L778.24 512H249.408zM511.68 352.64a207.872 207.872 0 01189.184-96.192 160 160 0 00-314.752 5.632c52.608 12.992 97.28 46.08 125.568 90.56z"
  }, null, -1);
  const _hoisted_3$2i = [
    _hoisted_2$2i
  ];
  function _sfc_render$2i(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2i, _hoisted_3$2i);
  }
  var iceCream = /* @__PURE__ */ _export_sfc(_sfc_main$2i, [["render", _sfc_render$2i]]);

  const _sfc_main$2h = vue.defineComponent({
    name: "IceDrink"
  });
  const _hoisted_1$2h = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2h = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 448v128h239.68l16.064-128H512zm-64 0H256.256l16.064 128H448V448zm64-255.36V384h247.744A256.128 256.128 0 00512 192.64zm-64 8.064A256.448 256.448 0 00264.256 384H448V200.704zm64-72.064A320.128 320.128 0 01825.472 384H896a32 32 0 110 64h-64v1.92l-56.96 454.016A64 64 0 01711.552 960H312.448a64 64 0 01-63.488-56.064L192 449.92V448h-64a32 32 0 010-64h70.528A320.384 320.384 0 01448 135.04V96a96 96 0 0196-96h128a32 32 0 110 64H544a32 32 0 00-32 32v32.64zM743.68 640H280.32l32.128 256h399.104l32.128-256z"
  }, null, -1);
  const _hoisted_3$2h = [
    _hoisted_2$2h
  ];
  function _sfc_render$2h(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2h, _hoisted_3$2h);
  }
  var iceDrink = /* @__PURE__ */ _export_sfc(_sfc_main$2h, [["render", _sfc_render$2h]]);

  const _sfc_main$2g = vue.defineComponent({
    name: "IceTea"
  });
  const _hoisted_1$2g = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2g = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M197.696 259.648a320.128 320.128 0 01628.608 0A96 96 0 01896 352v64a96 96 0 01-71.616 92.864l-49.408 395.072A64 64 0 01711.488 960H312.512a64 64 0 01-63.488-56.064l-49.408-395.072A96 96 0 01128 416v-64a96 96 0 0169.696-92.352zM264.064 256h495.872a256.128 256.128 0 00-495.872 0zm495.424 256H264.512l48 384h398.976l48-384zM224 448h576a32 32 0 0032-32v-64a32 32 0 00-32-32H224a32 32 0 00-32 32v64a32 32 0 0032 32zm160 192h64v64h-64v-64zm192 64h64v64h-64v-64zm-128 64h64v64h-64v-64zm64-192h64v64h-64v-64z"
  }, null, -1);
  const _hoisted_3$2g = [
    _hoisted_2$2g
  ];
  function _sfc_render$2g(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2g, _hoisted_3$2g);
  }
  var iceTea = /* @__PURE__ */ _export_sfc(_sfc_main$2g, [["render", _sfc_render$2g]]);

  const _sfc_main$2f = vue.defineComponent({
    name: "InfoFilled"
  });
  const _hoisted_1$2f = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896.064A448 448 0 01512 64zm67.2 275.072c33.28 0 60.288-23.104 60.288-57.344s-27.072-57.344-60.288-57.344c-33.28 0-60.16 23.104-60.16 57.344s26.88 57.344 60.16 57.344zM590.912 699.2c0-6.848 2.368-24.64 1.024-34.752l-52.608 60.544c-10.88 11.456-24.512 19.392-30.912 17.28a12.992 12.992 0 01-8.256-14.72l87.68-276.992c7.168-35.136-12.544-67.2-54.336-71.296-44.096 0-108.992 44.736-148.48 101.504 0 6.784-1.28 23.68.064 33.792l52.544-60.608c10.88-11.328 23.552-19.328 29.952-17.152a12.8 12.8 0 017.808 16.128L388.48 728.576c-10.048 32.256 8.96 63.872 55.04 71.04 67.84 0 107.904-43.648 147.456-100.416z"
  }, null, -1);
  const _hoisted_3$2f = [
    _hoisted_2$2f
  ];
  function _sfc_render$2f(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2f, _hoisted_3$2f);
  }
  var infoFilled = /* @__PURE__ */ _export_sfc(_sfc_main$2f, [["render", _sfc_render$2f]]);

  const _sfc_main$2e = vue.defineComponent({
    name: "Iphone"
  });
  const _hoisted_1$2e = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2e = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 768v96.064a64 64 0 0064 64h448a64 64 0 0064-64V768H224zm0-64h576V160a64 64 0 00-64-64H288a64 64 0 00-64 64v544zm32 288a96 96 0 01-96-96V128a96 96 0 0196-96h512a96 96 0 0196 96v768a96 96 0 01-96 96H256zm304-144a48 48 0 11-96 0 48 48 0 0196 0z"
  }, null, -1);
  const _hoisted_3$2e = [
    _hoisted_2$2e
  ];
  function _sfc_render$2e(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2e, _hoisted_3$2e);
  }
  var iphone = /* @__PURE__ */ _export_sfc(_sfc_main$2e, [["render", _sfc_render$2e]]);

  const _sfc_main$2d = vue.defineComponent({
    name: "Key"
  });
  const _hoisted_1$2d = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2d = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M448 456.064V96a32 32 0 0132-32.064L672 64a32 32 0 010 64H512v128h160a32 32 0 010 64H512v128a256 256 0 11-64 8.064zM512 896a192 192 0 100-384 192 192 0 000 384z"
  }, null, -1);
  const _hoisted_3$2d = [
    _hoisted_2$2d
  ];
  function _sfc_render$2d(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2d, _hoisted_3$2d);
  }
  var key = /* @__PURE__ */ _export_sfc(_sfc_main$2d, [["render", _sfc_render$2d]]);

  const _sfc_main$2c = vue.defineComponent({
    name: "KnifeFork"
  });
  const _hoisted_1$2c = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2c = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 410.56V96a32 32 0 0164 0v314.56A96 96 0 00384 320V96a32 32 0 0164 0v224a160 160 0 01-128 156.8V928a32 32 0 11-64 0V476.8A160 160 0 01128 320V96a32 32 0 0164 0v224a96 96 0 0064 90.56zm384-250.24V544h126.72c-3.328-78.72-12.928-147.968-28.608-207.744-14.336-54.528-46.848-113.344-98.112-175.872zM640 608v320a32 32 0 11-64 0V64h64c85.312 89.472 138.688 174.848 160 256 21.312 81.152 32 177.152 32 288H640z"
  }, null, -1);
  const _hoisted_3$2c = [
    _hoisted_2$2c
  ];
  function _sfc_render$2c(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2c, _hoisted_3$2c);
  }
  var knifeFork = /* @__PURE__ */ _export_sfc(_sfc_main$2c, [["render", _sfc_render$2c]]);

  const _sfc_main$2b = vue.defineComponent({
    name: "Lightning"
  });
  const _hoisted_1$2b = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 671.36v64.128A239.808 239.808 0 0163.744 496.192a240.32 240.32 0 01199.488-236.8 256.128 256.128 0 01487.872-30.976A256.064 256.064 0 01736 734.016v-64.768a192 192 0 003.328-377.92l-35.2-6.592-12.8-33.408a192.064 192.064 0 00-365.952 23.232l-9.92 40.896-41.472 7.04a176.32 176.32 0 00-146.24 173.568c0 91.968 70.464 167.36 160.256 175.232z"
  }, null, -1);
  const _hoisted_3$2b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M416 736a32 32 0 01-27.776-47.872l128-224a32 32 0 1155.552 31.744L471.168 672H608a32 32 0 0127.776 47.872l-128 224a32 32 0 11-55.68-31.744L552.96 736H416z"
  }, null, -1);
  const _hoisted_4$I = [
    _hoisted_2$2b,
    _hoisted_3$2b
  ];
  function _sfc_render$2b(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2b, _hoisted_4$I);
  }
  var lightning = /* @__PURE__ */ _export_sfc(_sfc_main$2b, [["render", _sfc_render$2b]]);

  const _sfc_main$2a = vue.defineComponent({
    name: "Link"
  });
  const _hoisted_1$2a = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M715.648 625.152L670.4 579.904l90.496-90.56c75.008-74.944 85.12-186.368 22.656-248.896-62.528-62.464-173.952-52.352-248.96 22.656L444.16 353.6l-45.248-45.248 90.496-90.496c100.032-99.968 251.968-110.08 339.456-22.656 87.488 87.488 77.312 239.424-22.656 339.456l-90.496 90.496zm-90.496 90.496l-90.496 90.496C434.624 906.112 282.688 916.224 195.2 828.8c-87.488-87.488-77.312-239.424 22.656-339.456l90.496-90.496 45.248 45.248-90.496 90.56c-75.008 74.944-85.12 186.368-22.656 248.896 62.528 62.464 173.952 52.352 248.96-22.656l90.496-90.496 45.248 45.248zm0-362.048l45.248 45.248L398.848 670.4 353.6 625.152 625.152 353.6z"
  }, null, -1);
  const _hoisted_3$2a = [
    _hoisted_2$2a
  ];
  function _sfc_render$2a(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2a, _hoisted_3$2a);
  }
  var link = /* @__PURE__ */ _export_sfc(_sfc_main$2a, [["render", _sfc_render$2a]]);

  const _sfc_main$29 = vue.defineComponent({
    name: "List"
  });
  const _hoisted_1$29 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$29 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 192h160v736H160V192h160v64h384v-64zM288 512h448v-64H288v64zm0 256h448v-64H288v64zm96-576V96h256v96H384z"
  }, null, -1);
  const _hoisted_3$29 = [
    _hoisted_2$29
  ];
  function _sfc_render$29(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$29, _hoisted_3$29);
  }
  var list = /* @__PURE__ */ _export_sfc(_sfc_main$29, [["render", _sfc_render$29]]);

  const _sfc_main$28 = vue.defineComponent({
    name: "Loading"
  });
  const _hoisted_1$28 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$28 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a32 32 0 0132 32v192a32 32 0 01-64 0V96a32 32 0 0132-32zm0 640a32 32 0 0132 32v192a32 32 0 11-64 0V736a32 32 0 0132-32zm448-192a32 32 0 01-32 32H736a32 32 0 110-64h192a32 32 0 0132 32zm-640 0a32 32 0 01-32 32H96a32 32 0 010-64h192a32 32 0 0132 32zM195.2 195.2a32 32 0 0145.248 0L376.32 331.008a32 32 0 01-45.248 45.248L195.2 240.448a32 32 0 010-45.248zm452.544 452.544a32 32 0 0145.248 0L828.8 783.552a32 32 0 01-45.248 45.248L647.744 692.992a32 32 0 010-45.248zM828.8 195.264a32 32 0 010 45.184L692.992 376.32a32 32 0 01-45.248-45.248l135.808-135.808a32 32 0 0145.248 0zm-452.544 452.48a32 32 0 010 45.248L240.448 828.8a32 32 0 01-45.248-45.248l135.808-135.808a32 32 0 0145.248 0z"
  }, null, -1);
  const _hoisted_3$28 = [
    _hoisted_2$28
  ];
  function _sfc_render$28(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$28, _hoisted_3$28);
  }
  var loading = /* @__PURE__ */ _export_sfc(_sfc_main$28, [["render", _sfc_render$28]]);

  const _sfc_main$27 = vue.defineComponent({
    name: "LocationFilled"
  });
  const _hoisted_1$27 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$27 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 928c23.936 0 117.504-68.352 192.064-153.152C803.456 661.888 864 535.808 864 416c0-189.632-155.84-320-352-320S160 226.368 160 416c0 120.32 60.544 246.4 159.936 359.232C394.432 859.84 488 928 512 928zm0-435.2a64 64 0 100-128 64 64 0 000 128zm0 140.8a204.8 204.8 0 110-409.6 204.8 204.8 0 010 409.6z"
  }, null, -1);
  const _hoisted_3$27 = [
    _hoisted_2$27
  ];
  function _sfc_render$27(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$27, _hoisted_3$27);
  }
  var locationFilled = /* @__PURE__ */ _export_sfc(_sfc_main$27, [["render", _sfc_render$27]]);

  const _sfc_main$26 = vue.defineComponent({
    name: "LocationInformation"
  });
  const _hoisted_1$26 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$26 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 896h448q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_3$26 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M800 416a288 288 0 10-576 0c0 118.144 94.528 272.128 288 456.576C705.472 688.128 800 534.144 800 416zM512 960C277.312 746.688 160 565.312 160 416a352 352 0 01704 0c0 149.312-117.312 330.688-352 544z"
  }, null, -1);
  const _hoisted_4$H = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 512a96 96 0 100-192 96 96 0 000 192zm0 64a160 160 0 110-320 160 160 0 010 320z"
  }, null, -1);
  const _hoisted_5$b = [
    _hoisted_2$26,
    _hoisted_3$26,
    _hoisted_4$H
  ];
  function _sfc_render$26(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$26, _hoisted_5$b);
  }
  var locationInformation = /* @__PURE__ */ _export_sfc(_sfc_main$26, [["render", _sfc_render$26]]);

  const _sfc_main$25 = vue.defineComponent({
    name: "Location"
  });
  const _hoisted_1$25 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$25 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M800 416a288 288 0 10-576 0c0 118.144 94.528 272.128 288 456.576C705.472 688.128 800 534.144 800 416zM512 960C277.312 746.688 160 565.312 160 416a352 352 0 01704 0c0 149.312-117.312 330.688-352 544z"
  }, null, -1);
  const _hoisted_3$25 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 512a96 96 0 100-192 96 96 0 000 192zm0 64a160 160 0 110-320 160 160 0 010 320z"
  }, null, -1);
  const _hoisted_4$G = [
    _hoisted_2$25,
    _hoisted_3$25
  ];
  function _sfc_render$25(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$25, _hoisted_4$G);
  }
  var location = /* @__PURE__ */ _export_sfc(_sfc_main$25, [["render", _sfc_render$25]]);

  const _sfc_main$24 = vue.defineComponent({
    name: "Lock"
  });
  const _hoisted_1$24 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$24 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 448a32 32 0 00-32 32v384a32 32 0 0032 32h576a32 32 0 0032-32V480a32 32 0 00-32-32H224zm0-64h576a96 96 0 0196 96v384a96 96 0 01-96 96H224a96 96 0 01-96-96V480a96 96 0 0196-96z"
  }, null, -1);
  const _hoisted_3$24 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 544a32 32 0 0132 32v192a32 32 0 11-64 0V576a32 32 0 0132-32zM704 384v-64a192 192 0 10-384 0v64h384zM512 64a256 256 0 01256 256v128H256V320A256 256 0 01512 64z"
  }, null, -1);
  const _hoisted_4$F = [
    _hoisted_2$24,
    _hoisted_3$24
  ];
  function _sfc_render$24(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$24, _hoisted_4$F);
  }
  var lock = /* @__PURE__ */ _export_sfc(_sfc_main$24, [["render", _sfc_render$24]]);

  const _sfc_main$23 = vue.defineComponent({
    name: "Lollipop"
  });
  const _hoisted_1$23 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$23 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M513.28 448a64 64 0 1176.544 49.728A96 96 0 00768 448h64a160 160 0 01-320 0h1.28zm-126.976-29.696a256 256 0 1043.52-180.48A256 256 0 01832 448h-64a192 192 0 00-381.696-29.696zm105.664 249.472L285.696 874.048a96 96 0 01-135.68-135.744l206.208-206.272a320 320 0 11135.744 135.744zm-54.464-36.032a321.92 321.92 0 01-45.248-45.248L195.2 783.552a32 32 0 1045.248 45.248l197.056-197.12z"
  }, null, -1);
  const _hoisted_3$23 = [
    _hoisted_2$23
  ];
  function _sfc_render$23(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$23, _hoisted_3$23);
  }
  var lollipop = /* @__PURE__ */ _export_sfc(_sfc_main$23, [["render", _sfc_render$23]]);

  const _sfc_main$22 = vue.defineComponent({
    name: "MagicStick"
  });
  const _hoisted_1$22 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$22 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64h64v192h-64V64zm0 576h64v192h-64V640zM160 480v-64h192v64H160zm576 0v-64h192v64H736zM249.856 199.04l45.248-45.184L430.848 289.6 385.6 334.848 249.856 199.104zM657.152 606.4l45.248-45.248 135.744 135.744-45.248 45.248L657.152 606.4zM114.048 923.2L68.8 877.952l316.8-316.8 45.248 45.248-316.8 316.8zM702.4 334.848L657.152 289.6l135.744-135.744 45.248 45.248L702.4 334.848z"
  }, null, -1);
  const _hoisted_3$22 = [
    _hoisted_2$22
  ];
  function _sfc_render$22(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$22, _hoisted_3$22);
  }
  var magicStick = /* @__PURE__ */ _export_sfc(_sfc_main$22, [["render", _sfc_render$22]]);

  const _sfc_main$21 = vue.defineComponent({
    name: "Magnet"
  });
  const _hoisted_1$21 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$21 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M832 320V192H704v320a192 192 0 11-384 0V192H192v128h128v64H192v128a320 320 0 00640 0V384H704v-64h128zM640 512V128h256v384a384 384 0 11-768 0V128h256v384a128 128 0 10256 0z"
  }, null, -1);
  const _hoisted_3$21 = [
    _hoisted_2$21
  ];
  function _sfc_render$21(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$21, _hoisted_3$21);
  }
  var magnet = /* @__PURE__ */ _export_sfc(_sfc_main$21, [["render", _sfc_render$21]]);

  const _sfc_main$20 = vue.defineComponent({
    name: "Male"
  });
  const _hoisted_1$20 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$20 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M399.5 849.5a225 225 0 100-450 225 225 0 000 450zm0 56.25a281.25 281.25 0 110-562.5 281.25 281.25 0 010 562.5zM652.625 118.25h225q28.125 0 28.125 28.125T877.625 174.5h-225q-28.125 0-28.125-28.125t28.125-28.125z"
  }, null, -1);
  const _hoisted_3$20 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M877.625 118.25q28.125 0 28.125 28.125v225q0 28.125-28.125 28.125T849.5 371.375v-225q0-28.125 28.125-28.125z"
  }, null, -1);
  const _hoisted_4$E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M604.813 458.9L565.1 419.131l292.613-292.668 39.825 39.824z"
  }, null, -1);
  const _hoisted_5$a = [
    _hoisted_2$20,
    _hoisted_3$20,
    _hoisted_4$E
  ];
  function _sfc_render$20(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$20, _hoisted_5$a);
  }
  var male = /* @__PURE__ */ _export_sfc(_sfc_main$20, [["render", _sfc_render$20]]);

  const _sfc_main$1$ = vue.defineComponent({
    name: "Management"
  });
  const _hoisted_1$1$ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1$ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M576 128v288l96-96 96 96V128h128v768H320V128h256zm-448 0h128v768H128V128z"
  }, null, -1);
  const _hoisted_3$1$ = [
    _hoisted_2$1$
  ];
  function _sfc_render$1$(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1$, _hoisted_3$1$);
  }
  var management = /* @__PURE__ */ _export_sfc(_sfc_main$1$, [["render", _sfc_render$1$]]);

  const _sfc_main$1_ = vue.defineComponent({
    name: "MapLocation"
  });
  const _hoisted_1$1_ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1_ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M800 416a288 288 0 10-576 0c0 118.144 94.528 272.128 288 456.576C705.472 688.128 800 534.144 800 416zM512 960C277.312 746.688 160 565.312 160 416a352 352 0 01704 0c0 149.312-117.312 330.688-352 544z"
  }, null, -1);
  const _hoisted_3$1_ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 448a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256zm345.6 192L960 960H672v-64H352v64H64l102.4-256h691.2zm-68.928 0H235.328l-76.8 192h706.944l-76.8-192z"
  }, null, -1);
  const _hoisted_4$D = [
    _hoisted_2$1_,
    _hoisted_3$1_
  ];
  function _sfc_render$1_(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1_, _hoisted_4$D);
  }
  var mapLocation = /* @__PURE__ */ _export_sfc(_sfc_main$1_, [["render", _sfc_render$1_]]);

  const _sfc_main$1Z = vue.defineComponent({
    name: "Medal"
  });
  const _hoisted_1$1Z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1Z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a256 256 0 100-512 256 256 0 000 512zm0 64a320 320 0 110-640 320 320 0 010 640z"
  }, null, -1);
  const _hoisted_3$1Z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M576 128H448v200a286.72 286.72 0 0164-8c19.52 0 40.832 2.688 64 8V128zm64 0v219.648c24.448 9.088 50.56 20.416 78.4 33.92L757.44 128H640zm-256 0H266.624l39.04 253.568c27.84-13.504 53.888-24.832 78.336-33.92V128zM229.312 64h565.376a32 32 0 0131.616 36.864L768 480c-113.792-64-199.104-96-256-96-56.896 0-142.208 32-256 96l-58.304-379.136A32 32 0 01229.312 64z"
  }, null, -1);
  const _hoisted_4$C = [
    _hoisted_2$1Z,
    _hoisted_3$1Z
  ];
  function _sfc_render$1Z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1Z, _hoisted_4$C);
  }
  var medal = /* @__PURE__ */ _export_sfc(_sfc_main$1Z, [["render", _sfc_render$1Z]]);

  const _sfc_main$1Y = vue.defineComponent({
    name: "Menu"
  });
  const _hoisted_1$1Y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1Y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 448a32 32 0 01-32-32V160.064a32 32 0 0132-32h256a32 32 0 0132 32V416a32 32 0 01-32 32H160zm448 0a32 32 0 01-32-32V160.064a32 32 0 0132-32h255.936a32 32 0 0132 32V416a32 32 0 01-32 32H608zM160 896a32 32 0 01-32-32V608a32 32 0 0132-32h256a32 32 0 0132 32v256a32 32 0 01-32 32H160zm448 0a32 32 0 01-32-32V608a32 32 0 0132-32h255.936a32 32 0 0132 32v256a32 32 0 01-32 32H608z"
  }, null, -1);
  const _hoisted_3$1Y = [
    _hoisted_2$1Y
  ];
  function _sfc_render$1Y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1Y, _hoisted_3$1Y);
  }
  var menu = /* @__PURE__ */ _export_sfc(_sfc_main$1Y, [["render", _sfc_render$1Y]]);

  const _sfc_main$1X = vue.defineComponent({
    name: "MessageBox"
  });
  const _hoisted_1$1X = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1X = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 384h448v64H288v-64zm96-128h256v64H384v-64zM131.456 512H384v128h256V512h252.544L721.856 192H302.144L131.456 512zM896 576H704v128H320V576H128v256h768V576zM275.776 128h472.448a32 32 0 0128.608 17.664l179.84 359.552A32 32 0 01960 519.552V864a32 32 0 01-32 32H96a32 32 0 01-32-32V519.552a32 32 0 013.392-14.336l179.776-359.552A32 32 0 01275.776 128z"
  }, null, -1);
  const _hoisted_3$1X = [
    _hoisted_2$1X
  ];
  function _sfc_render$1X(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1X, _hoisted_3$1X);
  }
  var messageBox = /* @__PURE__ */ _export_sfc(_sfc_main$1X, [["render", _sfc_render$1X]]);

  const _sfc_main$1W = vue.defineComponent({
    name: "Message"
  });
  const _hoisted_1$1W = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1W = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 224v512a64 64 0 0064 64h640a64 64 0 0064-64V224H128zm0-64h768a64 64 0 0164 64v512a128 128 0 01-128 128H192A128 128 0 0164 736V224a64 64 0 0164-64z"
  }, null, -1);
  const _hoisted_3$1W = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M904 224L656.512 506.88a192 192 0 01-289.024 0L120 224h784zm-698.944 0l210.56 240.704a128 128 0 00192.704 0L818.944 224H205.056z"
  }, null, -1);
  const _hoisted_4$B = [
    _hoisted_2$1W,
    _hoisted_3$1W
  ];
  function _sfc_render$1W(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1W, _hoisted_4$B);
  }
  var message = /* @__PURE__ */ _export_sfc(_sfc_main$1W, [["render", _sfc_render$1W]]);

  const _sfc_main$1V = vue.defineComponent({
    name: "Mic"
  });
  const _hoisted_1$1V = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1V = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 704h160a64 64 0 0064-64v-32h-96a32 32 0 010-64h96v-96h-96a32 32 0 010-64h96v-96h-96a32 32 0 010-64h96v-32a64 64 0 00-64-64H384a64 64 0 00-64 64v32h96a32 32 0 010 64h-96v96h96a32 32 0 010 64h-96v96h96a32 32 0 010 64h-96v32a64 64 0 0064 64h96zm64 64v128h192a32 32 0 110 64H288a32 32 0 110-64h192V768h-96a128 128 0 01-128-128V192A128 128 0 01384 64h256a128 128 0 01128 128v448a128 128 0 01-128 128h-96z"
  }, null, -1);
  const _hoisted_3$1V = [
    _hoisted_2$1V
  ];
  function _sfc_render$1V(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1V, _hoisted_3$1V);
  }
  var mic = /* @__PURE__ */ _export_sfc(_sfc_main$1V, [["render", _sfc_render$1V]]);

  const _sfc_main$1U = vue.defineComponent({
    name: "Microphone"
  });
  const _hoisted_1$1U = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1U = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 128a128 128 0 00-128 128v256a128 128 0 10256 0V256a128 128 0 00-128-128zm0-64a192 192 0 01192 192v256a192 192 0 11-384 0V256A192 192 0 01512 64zm-32 832v-64a288 288 0 01-288-288v-32a32 32 0 0164 0v32a224 224 0 00224 224h64a224 224 0 00224-224v-32a32 32 0 1164 0v32a288 288 0 01-288 288v64h64a32 32 0 110 64H416a32 32 0 110-64h64z"
  }, null, -1);
  const _hoisted_3$1U = [
    _hoisted_2$1U
  ];
  function _sfc_render$1U(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1U, _hoisted_3$1U);
  }
  var microphone = /* @__PURE__ */ _export_sfc(_sfc_main$1U, [["render", _sfc_render$1U]]);

  const _sfc_main$1T = vue.defineComponent({
    name: "MilkTea"
  });
  const _hoisted_1$1T = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1T = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M416 128V96a96 96 0 0196-96h128a32 32 0 110 64H512a32 32 0 00-32 32v32h320a96 96 0 0111.712 191.296l-39.68 581.056A64 64 0 01708.224 960H315.776a64 64 0 01-63.872-59.648l-39.616-581.056A96 96 0 01224 128h192zM276.48 320l39.296 576h392.448l4.8-70.784a224.064 224.064 0 0130.016-439.808L747.52 320H276.48zM224 256h576a32 32 0 100-64H224a32 32 0 000 64zm493.44 503.872l21.12-309.12a160 160 0 00-21.12 309.12z"
  }, null, -1);
  const _hoisted_3$1T = [
    _hoisted_2$1T
  ];
  function _sfc_render$1T(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1T, _hoisted_3$1T);
  }
  var milkTea = /* @__PURE__ */ _export_sfc(_sfc_main$1T, [["render", _sfc_render$1T]]);

  const _sfc_main$1S = vue.defineComponent({
    name: "Minus"
  });
  const _hoisted_1$1S = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1S = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 544h768a32 32 0 100-64H128a32 32 0 000 64z"
  }, null, -1);
  const _hoisted_3$1S = [
    _hoisted_2$1S
  ];
  function _sfc_render$1S(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1S, _hoisted_3$1S);
  }
  var minus = /* @__PURE__ */ _export_sfc(_sfc_main$1S, [["render", _sfc_render$1S]]);

  const _sfc_main$1R = vue.defineComponent({
    name: "Money"
  });
  const _hoisted_1$1R = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 640v192h640V384H768v-64h150.976c14.272 0 19.456 1.472 24.64 4.288a29.056 29.056 0 0112.16 12.096c2.752 5.184 4.224 10.368 4.224 24.64v493.952c0 14.272-1.472 19.456-4.288 24.64a29.056 29.056 0 01-12.096 12.16c-5.184 2.752-10.368 4.224-24.64 4.224H233.024c-14.272 0-19.456-1.472-24.64-4.288a29.056 29.056 0 01-12.16-12.096c-2.688-5.184-4.224-10.368-4.224-24.576V640h64z"
  }, null, -1);
  const _hoisted_3$1R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 192H128v448h640V192zm64-22.976v493.952c0 14.272-1.472 19.456-4.288 24.64a29.056 29.056 0 01-12.096 12.16c-5.184 2.752-10.368 4.224-24.64 4.224H105.024c-14.272 0-19.456-1.472-24.64-4.288a29.056 29.056 0 01-12.16-12.096C65.536 682.432 64 677.248 64 663.04V169.024c0-14.272 1.472-19.456 4.288-24.64a29.056 29.056 0 0112.096-12.16C85.568 129.536 90.752 128 104.96 128h685.952c14.272 0 19.456 1.472 24.64 4.288a29.056 29.056 0 0112.16 12.096c2.752 5.184 4.224 10.368 4.224 24.64z"
  }, null, -1);
  const _hoisted_4$A = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M448 576a160 160 0 110-320 160 160 0 010 320zm0-64a96 96 0 100-192 96 96 0 000 192z"
  }, null, -1);
  const _hoisted_5$9 = [
    _hoisted_2$1R,
    _hoisted_3$1R,
    _hoisted_4$A
  ];
  function _sfc_render$1R(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1R, _hoisted_5$9);
  }
  var money = /* @__PURE__ */ _export_sfc(_sfc_main$1R, [["render", _sfc_render$1R]]);

  const _sfc_main$1Q = vue.defineComponent({
    name: "Monitor"
  });
  const _hoisted_1$1Q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1Q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 768v128h192a32 32 0 110 64H288a32 32 0 110-64h192V768H192A128 128 0 0164 640V256a128 128 0 01128-128h640a128 128 0 01128 128v384a128 128 0 01-128 128H544zM192 192a64 64 0 00-64 64v384a64 64 0 0064 64h640a64 64 0 0064-64V256a64 64 0 00-64-64H192z"
  }, null, -1);
  const _hoisted_3$1Q = [
    _hoisted_2$1Q
  ];
  function _sfc_render$1Q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1Q, _hoisted_3$1Q);
  }
  var monitor = /* @__PURE__ */ _export_sfc(_sfc_main$1Q, [["render", _sfc_render$1Q]]);

  const _sfc_main$1P = vue.defineComponent({
    name: "MoonNight"
  });
  const _hoisted_1$1P = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1P = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 512a448 448 0 01215.872-383.296A384 384 0 00213.76 640h188.8A448.256 448.256 0 01384 512zM171.136 704a448 448 0 01636.992-575.296A384 384 0 00499.328 704h-328.32z"
  }, null, -1);
  const _hoisted_3$1P = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M32 640h960q32 0 32 32t-32 32H32q-32 0-32-32t32-32zM160 768h384a32 32 0 110 64H160a32 32 0 110-64zm160 127.68l224 .256a32 32 0 0132 32V928a32 32 0 01-32 32l-224-.384a32 32 0 01-32-32v-.064a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4$z = [
    _hoisted_2$1P,
    _hoisted_3$1P
  ];
  function _sfc_render$1P(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1P, _hoisted_4$z);
  }
  var moonNight = /* @__PURE__ */ _export_sfc(_sfc_main$1P, [["render", _sfc_render$1P]]);

  const _sfc_main$1O = vue.defineComponent({
    name: "Moon"
  });
  const _hoisted_1$1O = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M240.448 240.448a384 384 0 10559.424 525.696 448 448 0 01-542.016-542.08 390.592 390.592 0 00-17.408 16.384zm181.056 362.048a384 384 0 00525.632 16.384A448 448 0 11405.056 76.8a384 384 0 0016.448 525.696z"
  }, null, -1);
  const _hoisted_3$1O = [
    _hoisted_2$1O
  ];
  function _sfc_render$1O(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1O, _hoisted_3$1O);
  }
  var moon = /* @__PURE__ */ _export_sfc(_sfc_main$1O, [["render", _sfc_render$1O]]);

  const _sfc_main$1N = vue.defineComponent({
    name: "MoreFilled"
  });
  const _hoisted_1$1N = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1N = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M176 416a112 112 0 110 224 112 112 0 010-224zm336 0a112 112 0 110 224 112 112 0 010-224zm336 0a112 112 0 110 224 112 112 0 010-224z"
  }, null, -1);
  const _hoisted_3$1N = [
    _hoisted_2$1N
  ];
  function _sfc_render$1N(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1N, _hoisted_3$1N);
  }
  var moreFilled = /* @__PURE__ */ _export_sfc(_sfc_main$1N, [["render", _sfc_render$1N]]);

  const _sfc_main$1M = vue.defineComponent({
    name: "More"
  });
  const _hoisted_1$1M = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1M = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M176 416a112 112 0 100 224 112 112 0 000-224m0 64a48 48 0 110 96 48 48 0 010-96zm336-64a112 112 0 110 224 112 112 0 010-224zm0 64a48 48 0 100 96 48 48 0 000-96zm336-64a112 112 0 110 224 112 112 0 010-224zm0 64a48 48 0 100 96 48 48 0 000-96z"
  }, null, -1);
  const _hoisted_3$1M = [
    _hoisted_2$1M
  ];
  function _sfc_render$1M(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1M, _hoisted_3$1M);
  }
  var more = /* @__PURE__ */ _export_sfc(_sfc_main$1M, [["render", _sfc_render$1M]]);

  const _sfc_main$1L = vue.defineComponent({
    name: "MostlyCloudy"
  });
  const _hoisted_1$1L = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1L = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M737.216 357.952L704 349.824l-11.776-32a192.064 192.064 0 00-367.424 23.04l-8.96 39.04-39.04 8.96A192.064 192.064 0 00320 768h368a207.808 207.808 0 00207.808-208 208.32 208.32 0 00-158.592-202.048zm15.168-62.208A272.32 272.32 0 01959.744 560a271.808 271.808 0 01-271.552 272H320a256 256 0 01-57.536-505.536 256.128 256.128 0 01489.92-30.72z"
  }, null, -1);
  const _hoisted_3$1L = [
    _hoisted_2$1L
  ];
  function _sfc_render$1L(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1L, _hoisted_3$1L);
  }
  var mostlyCloudy = /* @__PURE__ */ _export_sfc(_sfc_main$1L, [["render", _sfc_render$1L]]);

  const _sfc_main$1K = vue.defineComponent({
    name: "Mouse"
  });
  const _hoisted_1$1K = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1K = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M438.144 256c-68.352 0-92.736 4.672-117.76 18.112-20.096 10.752-35.52 26.176-46.272 46.272C260.672 345.408 256 369.792 256 438.144v275.712c0 68.352 4.672 92.736 18.112 117.76 10.752 20.096 26.176 35.52 46.272 46.272C345.408 891.328 369.792 896 438.144 896h147.712c68.352 0 92.736-4.672 117.76-18.112 20.096-10.752 35.52-26.176 46.272-46.272C763.328 806.592 768 782.208 768 713.856V438.144c0-68.352-4.672-92.736-18.112-117.76a110.464 110.464 0 00-46.272-46.272C678.592 260.672 654.208 256 585.856 256H438.144zm0-64h147.712c85.568 0 116.608 8.96 147.904 25.6 31.36 16.768 55.872 41.344 72.576 72.64C823.104 321.536 832 352.576 832 438.08v275.84c0 85.504-8.96 116.544-25.6 147.84a174.464 174.464 0 01-72.64 72.576C702.464 951.104 671.424 960 585.92 960H438.08c-85.504 0-116.544-8.96-147.84-25.6a174.464 174.464 0 01-72.64-72.704c-16.768-31.296-25.664-62.336-25.664-147.84v-275.84c0-85.504 8.96-116.544 25.6-147.84a174.464 174.464 0 0172.768-72.576c31.232-16.704 62.272-25.6 147.776-25.6z"
  }, null, -1);
  const _hoisted_3$1K = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 320q32 0 32 32v128q0 32-32 32t-32-32V352q0-32 32-32zM544 224a32 32 0 01-64 0v-64a32 32 0 00-32-32h-96a32 32 0 010-64h96a96 96 0 0196 96v64z"
  }, null, -1);
  const _hoisted_4$y = [
    _hoisted_2$1K,
    _hoisted_3$1K
  ];
  function _sfc_render$1K(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1K, _hoisted_4$y);
  }
  var mouse = /* @__PURE__ */ _export_sfc(_sfc_main$1K, [["render", _sfc_render$1K]]);

  const _sfc_main$1J = vue.defineComponent({
    name: "Mug"
  });
  const _hoisted_1$1J = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1J = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M736 800V160H160v640a64 64 0 0064 64h448a64 64 0 0064-64zm64-544h63.552a96 96 0 0196 96v224a96 96 0 01-96 96H800v128a128 128 0 01-128 128H224A128 128 0 0196 800V128a32 32 0 0132-32h640a32 32 0 0132 32v128zm0 64v288h63.552a32 32 0 0032-32V352a32 32 0 00-32-32H800z"
  }, null, -1);
  const _hoisted_3$1J = [
    _hoisted_2$1J
  ];
  function _sfc_render$1J(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1J, _hoisted_3$1J);
  }
  var mug = /* @__PURE__ */ _export_sfc(_sfc_main$1J, [["render", _sfc_render$1J]]);

  const _sfc_main$1I = vue.defineComponent({
    name: "MuteNotification"
  });
  const _hoisted_1$1I = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1I = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M241.216 832l63.616-64H768V448c0-42.368-10.24-82.304-28.48-117.504l46.912-47.232C815.36 331.392 832 387.84 832 448v320h96a32 32 0 110 64H241.216zm-90.24 0H96a32 32 0 110-64h96V448a320.128 320.128 0 01256-313.6V128a64 64 0 11128 0v6.4a319.552 319.552 0 01171.648 97.088l-45.184 45.44A256 256 0 00256 448v278.336L151.04 832zM448 896h128a64 64 0 01-128 0z"
  }, null, -1);
  const _hoisted_3$1I = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M150.72 859.072a32 32 0 01-45.44-45.056l704-708.544a32 32 0 0145.44 45.056l-704 708.544z"
  }, null, -1);
  const _hoisted_4$x = [
    _hoisted_2$1I,
    _hoisted_3$1I
  ];
  function _sfc_render$1I(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1I, _hoisted_4$x);
  }
  var muteNotification = /* @__PURE__ */ _export_sfc(_sfc_main$1I, [["render", _sfc_render$1I]]);

  const _sfc_main$1H = vue.defineComponent({
    name: "Mute"
  });
  const _hoisted_1$1H = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1H = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M412.16 592.128l-45.44 45.44A191.232 191.232 0 01320 512V256a192 192 0 11384 0v44.352l-64 64V256a128 128 0 10-256 0v256c0 30.336 10.56 58.24 28.16 80.128zm51.968 38.592A128 128 0 00640 512v-57.152l64-64V512a192 192 0 01-287.68 166.528l47.808-47.808zM314.88 779.968l46.144-46.08A222.976 222.976 0 00480 768h64a224 224 0 00224-224v-32a32 32 0 1164 0v32a288 288 0 01-288 288v64h64a32 32 0 110 64H416a32 32 0 110-64h64v-64c-61.44 0-118.4-19.2-165.12-52.032zM266.752 737.6A286.976 286.976 0 01192 544v-32a32 32 0 0164 0v32c0 56.832 21.184 108.8 56.064 148.288L266.752 737.6z"
  }, null, -1);
  const _hoisted_3$1H = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M150.72 859.072a32 32 0 01-45.44-45.056l704-708.544a32 32 0 0145.44 45.056l-704 708.544z"
  }, null, -1);
  const _hoisted_4$w = [
    _hoisted_2$1H,
    _hoisted_3$1H
  ];
  function _sfc_render$1H(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1H, _hoisted_4$w);
  }
  var mute = /* @__PURE__ */ _export_sfc(_sfc_main$1H, [["render", _sfc_render$1H]]);

  const _sfc_main$1G = vue.defineComponent({
    name: "NoSmoking"
  });
  const _hoisted_1$1G = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1G = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M440.256 576H256v128h56.256l-64 64H224a32 32 0 01-32-32V544a32 32 0 0132-32h280.256l-64 64zm143.488 128H704V583.744L775.744 512H928a32 32 0 0132 32v192a32 32 0 01-32 32H519.744l64-64zM768 576v128h128V576H768zM738.304 368.448l45.248 45.248-497.856 497.856-45.248-45.248zM256 64h64v320h-64zM128 192h64v192h-64zM64 512h64v256H64z"
  }, null, -1);
  const _hoisted_3$1G = [
    _hoisted_2$1G
  ];
  function _sfc_render$1G(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1G, _hoisted_3$1G);
  }
  var noSmoking = /* @__PURE__ */ _export_sfc(_sfc_main$1G, [["render", _sfc_render$1G]]);

  const _sfc_main$1F = vue.defineComponent({
    name: "Notebook"
  });
  const _hoisted_1$1F = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1F = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 128v768h640V128H192zm-32-64h704a32 32 0 0132 32v832a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$1F = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M672 128h64v768h-64zM96 192h128q32 0 32 32t-32 32H96q-32 0-32-32t32-32zM96 384h128q32 0 32 32t-32 32H96q-32 0-32-32t32-32zM96 576h128q32 0 32 32t-32 32H96q-32 0-32-32t32-32zM96 768h128q32 0 32 32t-32 32H96q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_4$v = [
    _hoisted_2$1F,
    _hoisted_3$1F
  ];
  function _sfc_render$1F(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1F, _hoisted_4$v);
  }
  var notebook = /* @__PURE__ */ _export_sfc(_sfc_main$1F, [["render", _sfc_render$1F]]);

  const _sfc_main$1E = vue.defineComponent({
    name: "Notification"
  });
  const _hoisted_1$1E = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 128v64H256a64 64 0 00-64 64v512a64 64 0 0064 64h512a64 64 0 0064-64V512h64v256a128 128 0 01-128 128H256a128 128 0 01-128-128V256a128 128 0 01128-128h256z"
  }, null, -1);
  const _hoisted_3$1E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 384a128 128 0 100-256 128 128 0 000 256zm0 64a192 192 0 110-384 192 192 0 010 384z"
  }, null, -1);
  const _hoisted_4$u = [
    _hoisted_2$1E,
    _hoisted_3$1E
  ];
  function _sfc_render$1E(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1E, _hoisted_4$u);
  }
  var notification = /* @__PURE__ */ _export_sfc(_sfc_main$1E, [["render", _sfc_render$1E]]);

  const _sfc_main$1D = vue.defineComponent({
    name: "Odometer"
  });
  const _hoisted_1$1D = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1D = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$1D = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 512a320 320 0 11640 0 32 32 0 11-64 0 256 256 0 10-512 0 32 32 0 01-64 0z"
  }, null, -1);
  const _hoisted_4$t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M570.432 627.84A96 96 0 11509.568 608l60.992-187.776A32 32 0 11631.424 440l-60.992 187.776zM502.08 734.464a32 32 0 1019.84-60.928 32 32 0 00-19.84 60.928z"
  }, null, -1);
  const _hoisted_5$8 = [
    _hoisted_2$1D,
    _hoisted_3$1D,
    _hoisted_4$t
  ];
  function _sfc_render$1D(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1D, _hoisted_5$8);
  }
  var odometer = /* @__PURE__ */ _export_sfc(_sfc_main$1D, [["render", _sfc_render$1D]]);

  const _sfc_main$1C = vue.defineComponent({
    name: "OfficeBuilding"
  });
  const _hoisted_1$1C = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 128v704h384V128H192zm-32-64h448a32 32 0 0132 32v768a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$1C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 256h256v64H256v-64zm0 192h256v64H256v-64zm0 192h256v64H256v-64zm384-128h128v64H640v-64zm0 128h128v64H640v-64zM64 832h896v64H64v-64z"
  }, null, -1);
  const _hoisted_4$s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 384v448h192V384H640zm-32-64h256a32 32 0 0132 32v512a32 32 0 01-32 32H608a32 32 0 01-32-32V352a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_5$7 = [
    _hoisted_2$1C,
    _hoisted_3$1C,
    _hoisted_4$s
  ];
  function _sfc_render$1C(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1C, _hoisted_5$7);
  }
  var officeBuilding = /* @__PURE__ */ _export_sfc(_sfc_main$1C, [["render", _sfc_render$1C]]);

  const _sfc_main$1B = vue.defineComponent({
    name: "Open"
  });
  const _hoisted_1$1B = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1B = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M329.956 257.138a254.862 254.862 0 000 509.724h364.088a254.862 254.862 0 000-509.724H329.956zm0-72.818h364.088a327.68 327.68 0 110 655.36H329.956a327.68 327.68 0 110-655.36z"
  }, null, -1);
  const _hoisted_3$1B = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M694.044 621.227a109.227 109.227 0 100-218.454 109.227 109.227 0 000 218.454zm0 72.817a182.044 182.044 0 110-364.088 182.044 182.044 0 010 364.088z"
  }, null, -1);
  const _hoisted_4$r = [
    _hoisted_2$1B,
    _hoisted_3$1B
  ];
  function _sfc_render$1B(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1B, _hoisted_4$r);
  }
  var open = /* @__PURE__ */ _export_sfc(_sfc_main$1B, [["render", _sfc_render$1B]]);

  const _sfc_main$1A = vue.defineComponent({
    name: "Operation"
  });
  const _hoisted_1$1A = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1A = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M389.44 768a96.064 96.064 0 01181.12 0H896v64H570.56a96.064 96.064 0 01-181.12 0H128v-64h261.44zm192-288a96.064 96.064 0 01181.12 0H896v64H762.56a96.064 96.064 0 01-181.12 0H128v-64h453.44zm-320-288a96.064 96.064 0 01181.12 0H896v64H442.56a96.064 96.064 0 01-181.12 0H128v-64h133.44z"
  }, null, -1);
  const _hoisted_3$1A = [
    _hoisted_2$1A
  ];
  function _sfc_render$1A(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1A, _hoisted_3$1A);
  }
  var operation = /* @__PURE__ */ _export_sfc(_sfc_main$1A, [["render", _sfc_render$1A]]);

  const _sfc_main$1z = vue.defineComponent({
    name: "Opportunity"
  });
  const _hoisted_1$1z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 960v-64h192.064v64H384zm448-544a350.656 350.656 0 01-128.32 271.424C665.344 719.04 640 763.776 640 813.504V832H320v-14.336c0-48-19.392-95.36-57.216-124.992a351.552 351.552 0 01-128.448-344.256c25.344-136.448 133.888-248.128 269.76-276.48A352.384 352.384 0 01832 416zm-544 32c0-132.288 75.904-224 192-224v-64c-154.432 0-256 122.752-256 288h64z"
  }, null, -1);
  const _hoisted_3$1z = [
    _hoisted_2$1z
  ];
  function _sfc_render$1z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1z, _hoisted_3$1z);
  }
  var opportunity = /* @__PURE__ */ _export_sfc(_sfc_main$1z, [["render", _sfc_render$1z]]);

  const _sfc_main$1y = vue.defineComponent({
    name: "Orange"
  });
  const _hoisted_1$1y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 894.72a382.336 382.336 0 00215.936-89.472L577.024 622.272c-10.24 6.016-21.248 10.688-33.024 13.696v258.688zm261.248-134.784A382.336 382.336 0 00894.656 544H635.968c-3.008 11.776-7.68 22.848-13.696 33.024l182.976 182.912zM894.656 480a382.336 382.336 0 00-89.408-215.936L622.272 446.976c6.016 10.24 10.688 21.248 13.696 33.024h258.688zm-134.72-261.248A382.336 382.336 0 00544 129.344v258.688c11.776 3.008 22.848 7.68 33.024 13.696l182.912-182.976zM480 129.344a382.336 382.336 0 00-215.936 89.408l182.912 182.976c10.24-6.016 21.248-10.688 33.024-13.696V129.344zm-261.248 134.72A382.336 382.336 0 00129.344 480h258.688c3.008-11.776 7.68-22.848 13.696-33.024L218.752 264.064zM129.344 544a382.336 382.336 0 0089.408 215.936l182.976-182.912A127.232 127.232 0 01388.032 544H129.344zm134.72 261.248A382.336 382.336 0 00480 894.656V635.968a127.232 127.232 0 01-33.024-13.696L264.064 805.248zM512 960a448 448 0 110-896 448 448 0 010 896zm0-384a64 64 0 100-128 64 64 0 000 128z"
  }, null, -1);
  const _hoisted_3$1y = [
    _hoisted_2$1y
  ];
  function _sfc_render$1y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1y, _hoisted_3$1y);
  }
  var orange = /* @__PURE__ */ _export_sfc(_sfc_main$1y, [["render", _sfc_render$1y]]);

  const _sfc_main$1x = vue.defineComponent({
    name: "Paperclip"
  });
  const _hoisted_1$1x = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1x = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M602.496 240.448A192 192 0 11874.048 512l-316.8 316.8A256 256 0 01195.2 466.752L602.496 59.456l45.248 45.248L240.448 512A192 192 0 00512 783.552l316.8-316.8a128 128 0 10-181.056-181.056L353.6 579.904a32 32 0 1045.248 45.248l294.144-294.144 45.312 45.248L444.096 670.4a96 96 0 11-135.744-135.744l294.144-294.208z"
  }, null, -1);
  const _hoisted_3$1x = [
    _hoisted_2$1x
  ];
  function _sfc_render$1x(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1x, _hoisted_3$1x);
  }
  var paperclip = /* @__PURE__ */ _export_sfc(_sfc_main$1x, [["render", _sfc_render$1x]]);

  const _sfc_main$1w = vue.defineComponent({
    name: "PartlyCloudy"
  });
  const _hoisted_1$1w = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1w = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M598.4 895.872H328.192a256 256 0 01-34.496-510.528A352 352 0 11598.4 895.872zm-271.36-64h272.256a288 288 0 10-248.512-417.664L335.04 445.44l-34.816 3.584a192 192 0 0026.88 382.848z"
  }, null, -1);
  const _hoisted_3$1w = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M139.84 501.888a256 256 0 11417.856-277.12c-17.728 2.176-38.208 8.448-61.504 18.816A192 192 0 10189.12 460.48a6003.84 6003.84 0 00-49.28 41.408z"
  }, null, -1);
  const _hoisted_4$q = [
    _hoisted_2$1w,
    _hoisted_3$1w
  ];
  function _sfc_render$1w(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1w, _hoisted_4$q);
  }
  var partlyCloudy = /* @__PURE__ */ _export_sfc(_sfc_main$1w, [["render", _sfc_render$1w]]);

  const _sfc_main$1v = vue.defineComponent({
    name: "Pear"
  });
  const _hoisted_1$1v = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1v = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M542.336 258.816a443.255 443.255 0 00-9.024 25.088 32 32 0 11-60.8-20.032l1.088-3.328a162.688 162.688 0 00-122.048 131.392l-17.088 102.72-20.736 15.36C256.192 552.704 224 610.88 224 672c0 120.576 126.4 224 288 224s288-103.424 288-224c0-61.12-32.192-119.296-89.728-161.92l-20.736-15.424-17.088-102.72a162.688 162.688 0 00-130.112-133.12zm-40.128-66.56c7.936-15.552 16.576-30.08 25.92-43.776 23.296-33.92 49.408-59.776 78.528-77.12a32 32 0 1132.704 55.04c-20.544 12.224-40.064 31.552-58.432 58.304a316.608 316.608 0 00-9.792 15.104 226.688 226.688 0 01164.48 181.568l12.8 77.248C819.456 511.36 864 587.392 864 672c0 159.04-157.568 288-352 288S160 831.04 160 672c0-84.608 44.608-160.64 115.584-213.376l12.8-77.248a226.624 226.624 0 01213.76-189.184z"
  }, null, -1);
  const _hoisted_3$1v = [
    _hoisted_2$1v
  ];
  function _sfc_render$1v(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1v, _hoisted_3$1v);
  }
  var pear = /* @__PURE__ */ _export_sfc(_sfc_main$1v, [["render", _sfc_render$1v]]);

  const _sfc_main$1u = vue.defineComponent({
    name: "PhoneFilled"
  });
  const _hoisted_1$1u = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1u = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M199.232 125.568L90.624 379.008a32 32 0 006.784 35.2l512.384 512.384a32 32 0 0035.2 6.784l253.44-108.608a32 32 0 0010.048-52.032L769.6 633.92a32 32 0 00-36.928-5.952l-130.176 65.088-271.488-271.552 65.024-130.176a32 32 0 00-5.952-36.928L251.2 115.52a32 32 0 00-51.968 10.048z"
  }, null, -1);
  const _hoisted_3$1u = [
    _hoisted_2$1u
  ];
  function _sfc_render$1u(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1u, _hoisted_3$1u);
  }
  var phoneFilled = /* @__PURE__ */ _export_sfc(_sfc_main$1u, [["render", _sfc_render$1u]]);

  const _sfc_main$1t = vue.defineComponent({
    name: "Phone"
  });
  const _hoisted_1$1t = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M79.36 432.256L591.744 944.64a32 32 0 0035.2 6.784l253.44-108.544a32 32 0 009.984-52.032l-153.856-153.92a32 32 0 00-36.928-6.016l-69.888 34.944L358.08 394.24l35.008-69.888a32 32 0 00-5.952-36.928L233.152 133.568a32 32 0 00-52.032 10.048L72.512 397.056a32 32 0 006.784 35.2zm60.48-29.952l81.536-190.08L325.568 316.48l-24.64 49.216-20.608 41.216 32.576 32.64 271.552 271.552 32.64 32.64 41.216-20.672 49.28-24.576 104.192 104.128-190.08 81.472L139.84 402.304zM512 320v-64a256 256 0 01256 256h-64a192 192 0 00-192-192zm0-192V64a448 448 0 01448 448h-64a384 384 0 00-384-384z"
  }, null, -1);
  const _hoisted_3$1t = [
    _hoisted_2$1t
  ];
  function _sfc_render$1t(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1t, _hoisted_3$1t);
  }
  var phone = /* @__PURE__ */ _export_sfc(_sfc_main$1t, [["render", _sfc_render$1t]]);

  const _sfc_main$1s = vue.defineComponent({
    name: "PictureFilled"
  });
  const _hoisted_1$1s = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M96 896a32 32 0 01-32-32V160a32 32 0 0132-32h832a32 32 0 0132 32v704a32 32 0 01-32 32H96zm315.52-228.48l-68.928-68.928a32 32 0 00-45.248 0L128 768.064h778.688l-242.112-290.56a32 32 0 00-49.216 0L458.752 665.408a32 32 0 01-47.232 2.112zM256 384a96 96 0 10192.064-.064A96 96 0 00256 384z"
  }, null, -1);
  const _hoisted_3$1s = [
    _hoisted_2$1s
  ];
  function _sfc_render$1s(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1s, _hoisted_3$1s);
  }
  var pictureFilled = /* @__PURE__ */ _export_sfc(_sfc_main$1s, [["render", _sfc_render$1s]]);

  const _sfc_main$1r = vue.defineComponent({
    name: "PictureRounded"
  });
  const _hoisted_1$1r = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1r = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 128a384 384 0 100 768 384 384 0 000-768zm0-64a448 448 0 110 896 448 448 0 010-896z"
  }, null, -1);
  const _hoisted_3$1r = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 288q64 0 64 64t-64 64q-64 0-64-64t64-64zM214.656 790.656l-45.312-45.312 185.664-185.6a96 96 0 01123.712-10.24l138.24 98.688a32 32 0 0039.872-2.176L906.688 422.4l42.624 47.744L699.52 693.696a96 96 0 01-119.808 6.592l-138.24-98.752a32 32 0 00-41.152 3.456l-185.664 185.6z"
  }, null, -1);
  const _hoisted_4$p = [
    _hoisted_2$1r,
    _hoisted_3$1r
  ];
  function _sfc_render$1r(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1r, _hoisted_4$p);
  }
  var pictureRounded = /* @__PURE__ */ _export_sfc(_sfc_main$1r, [["render", _sfc_render$1r]]);

  const _sfc_main$1q = vue.defineComponent({
    name: "Picture"
  });
  const _hoisted_1$1q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 160v704h704V160H160zm-32-64h768a32 32 0 0132 32v768a32 32 0 01-32 32H128a32 32 0 01-32-32V128a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$1q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 288q64 0 64 64t-64 64q-64 0-64-64t64-64zM185.408 876.992l-50.816-38.912L350.72 556.032a96 96 0 01134.592-17.856l1.856 1.472 122.88 99.136a32 32 0 0044.992-4.864l216-269.888 49.92 39.936-215.808 269.824-.256.32a96 96 0 01-135.04 14.464l-122.88-99.072-.64-.512a32 32 0 00-44.8 5.952L185.408 876.992z"
  }, null, -1);
  const _hoisted_4$o = [
    _hoisted_2$1q,
    _hoisted_3$1q
  ];
  function _sfc_render$1q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1q, _hoisted_4$o);
  }
  var picture = /* @__PURE__ */ _export_sfc(_sfc_main$1q, [["render", _sfc_render$1q]]);

  const _sfc_main$1p = vue.defineComponent({
    name: "PieChart"
  });
  const _hoisted_1$1p = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1p = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M448 68.48v64.832A384.128 384.128 0 00512 896a384.128 384.128 0 00378.688-320h64.768A448.128 448.128 0 0164 512 448.128 448.128 0 01448 68.48z"
  }, null, -1);
  const _hoisted_3$1p = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M576 97.28V448h350.72A384.064 384.064 0 00576 97.28zM512 64V33.152A448 448 0 01990.848 512H512V64z"
  }, null, -1);
  const _hoisted_4$n = [
    _hoisted_2$1p,
    _hoisted_3$1p
  ];
  function _sfc_render$1p(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1p, _hoisted_4$n);
  }
  var pieChart = /* @__PURE__ */ _export_sfc(_sfc_main$1p, [["render", _sfc_render$1p]]);

  const _sfc_main$1o = vue.defineComponent({
    name: "Place"
  });
  const _hoisted_1$1o = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1o = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 512a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512z"
  }, null, -1);
  const _hoisted_3$1o = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 512a32 32 0 0132 32v256a32 32 0 11-64 0V544a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4$m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 649.088v64.96C269.76 732.352 192 771.904 192 800c0 37.696 139.904 96 320 96s320-58.304 320-96c0-28.16-77.76-67.648-192-85.952v-64.96C789.12 671.04 896 730.368 896 800c0 88.32-171.904 160-384 160s-384-71.68-384-160c0-69.696 106.88-128.96 256-150.912z"
  }, null, -1);
  const _hoisted_5$6 = [
    _hoisted_2$1o,
    _hoisted_3$1o,
    _hoisted_4$m
  ];
  function _sfc_render$1o(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1o, _hoisted_5$6);
  }
  var place = /* @__PURE__ */ _export_sfc(_sfc_main$1o, [["render", _sfc_render$1o]]);

  const _sfc_main$1n = vue.defineComponent({
    name: "Platform"
  });
  const _hoisted_1$1n = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1n = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M448 832v-64h128v64h192v64H256v-64h192zM128 704V128h768v576H128z"
  }, null, -1);
  const _hoisted_3$1n = [
    _hoisted_2$1n
  ];
  function _sfc_render$1n(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1n, _hoisted_3$1n);
  }
  var platform = /* @__PURE__ */ _export_sfc(_sfc_main$1n, [["render", _sfc_render$1n]]);

  const _sfc_main$1m = vue.defineComponent({
    name: "Plus"
  });
  const _hoisted_1$1m = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 480V128a32 32 0 0164 0v352h352a32 32 0 110 64H544v352a32 32 0 11-64 0V544H128a32 32 0 010-64h352z"
  }, null, -1);
  const _hoisted_3$1m = [
    _hoisted_2$1m
  ];
  function _sfc_render$1m(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1m, _hoisted_3$1m);
  }
  var plus = /* @__PURE__ */ _export_sfc(_sfc_main$1m, [["render", _sfc_render$1m]]);

  const _sfc_main$1l = vue.defineComponent({
    name: "Pointer"
  });
  const _hoisted_1$1l = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M511.552 128c-35.584 0-64.384 28.8-64.384 64.448v516.48L274.048 570.88a94.272 94.272 0 00-112.896-3.456 44.416 44.416 0 00-8.96 62.208L332.8 870.4A64 64 0 00384 896h512V575.232a64 64 0 00-45.632-61.312l-205.952-61.76A96 96 0 01576 360.192V192.448C576 156.8 547.2 128 511.552 128zM359.04 556.8l24.128 19.2V192.448a128.448 128.448 0 11256.832 0v167.744a32 32 0 0022.784 30.656l206.016 61.76A128 128 0 01960 575.232V896a64 64 0 01-64 64H384a128 128 0 01-102.4-51.2L101.056 668.032A108.416 108.416 0 01128 512.512a158.272 158.272 0 01185.984 8.32L359.04 556.8z"
  }, null, -1);
  const _hoisted_3$1l = [
    _hoisted_2$1l
  ];
  function _sfc_render$1l(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1l, _hoisted_3$1l);
  }
  var pointer = /* @__PURE__ */ _export_sfc(_sfc_main$1l, [["render", _sfc_render$1l]]);

  const _sfc_main$1k = vue.defineComponent({
    name: "Position"
  });
  const _hoisted_1$1k = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M249.6 417.088l319.744 43.072 39.168 310.272L845.12 178.88 249.6 417.088zm-129.024 47.168a32 32 0 01-7.68-61.44l777.792-311.04a32 32 0 0141.6 41.6l-310.336 775.68a32 32 0 01-61.44-7.808L512 516.992l-391.424-52.736z"
  }, null, -1);
  const _hoisted_3$1k = [
    _hoisted_2$1k
  ];
  function _sfc_render$1k(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1k, _hoisted_3$1k);
  }
  var position = /* @__PURE__ */ _export_sfc(_sfc_main$1k, [["render", _sfc_render$1k]]);

  const _sfc_main$1j = vue.defineComponent({
    name: "Postcard"
  });
  const _hoisted_1$1j = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 224a32 32 0 00-32 32v512a32 32 0 0032 32h704a32 32 0 0032-32V256a32 32 0 00-32-32H160zm0-64h704a96 96 0 0196 96v512a96 96 0 01-96 96H160a96 96 0 01-96-96V256a96 96 0 0196-96z"
  }, null, -1);
  const _hoisted_3$1j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 320a64 64 0 110 128 64 64 0 010-128zM288 448h256q32 0 32 32t-32 32H288q-32 0-32-32t32-32zM288 576h256q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_4$l = [
    _hoisted_2$1j,
    _hoisted_3$1j
  ];
  function _sfc_render$1j(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1j, _hoisted_4$l);
  }
  var postcard = /* @__PURE__ */ _export_sfc(_sfc_main$1j, [["render", _sfc_render$1j]]);

  const _sfc_main$1i = vue.defineComponent({
    name: "Pouring"
  });
  const _hoisted_1$1i = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1i = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M739.328 291.328l-35.2-6.592-12.8-33.408a192.064 192.064 0 00-365.952 23.232l-9.92 40.896-41.472 7.04a176.32 176.32 0 00-146.24 173.568c0 97.28 78.72 175.936 175.808 175.936h400a192 192 0 0035.776-380.672zM959.552 480a256 256 0 01-256 256h-400A239.808 239.808 0 0163.744 496.192a240.32 240.32 0 01199.488-236.8 256.128 256.128 0 01487.872-30.976A256.064 256.064 0 01959.552 480zM224 800a32 32 0 0132 32v96a32 32 0 11-64 0v-96a32 32 0 0132-32zm192 0a32 32 0 0132 32v96a32 32 0 11-64 0v-96a32 32 0 0132-32zm192 0a32 32 0 0132 32v96a32 32 0 11-64 0v-96a32 32 0 0132-32zm192 0a32 32 0 0132 32v96a32 32 0 11-64 0v-96a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$1i = [
    _hoisted_2$1i
  ];
  function _sfc_render$1i(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1i, _hoisted_3$1i);
  }
  var pouring = /* @__PURE__ */ _export_sfc(_sfc_main$1i, [["render", _sfc_render$1i]]);

  const _sfc_main$1h = vue.defineComponent({
    name: "Present"
  });
  const _hoisted_1$1h = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1h = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 896V640H192v-64h288V320H192v576h288zm64 0h288V320H544v256h288v64H544v256zM128 256h768v672a32 32 0 01-32 32H160a32 32 0 01-32-32V256z"
  }, null, -1);
  const _hoisted_3$1h = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M96 256h832q32 0 32 32t-32 32H96q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_4$k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M416 256a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256z"
  }, null, -1);
  const _hoisted_5$5 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M608 256a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256z"
  }, null, -1);
  const _hoisted_6$1 = [
    _hoisted_2$1h,
    _hoisted_3$1h,
    _hoisted_4$k,
    _hoisted_5$5
  ];
  function _sfc_render$1h(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1h, _hoisted_6$1);
  }
  var present = /* @__PURE__ */ _export_sfc(_sfc_main$1h, [["render", _sfc_render$1h]]);

  const _sfc_main$1g = vue.defineComponent({
    name: "PriceTag"
  });
  const _hoisted_1$1g = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1g = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 318.336V896h576V318.336L552.512 115.84a64 64 0 00-81.024 0L224 318.336zM593.024 66.304l259.2 212.096A32 32 0 01864 303.168V928a32 32 0 01-32 32H192a32 32 0 01-32-32V303.168a32 32 0 0111.712-24.768l259.2-212.096a128 128 0 01162.112 0z"
  }, null, -1);
  const _hoisted_3$1g = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 448a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256z"
  }, null, -1);
  const _hoisted_4$j = [
    _hoisted_2$1g,
    _hoisted_3$1g
  ];
  function _sfc_render$1g(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1g, _hoisted_4$j);
  }
  var priceTag = /* @__PURE__ */ _export_sfc(_sfc_main$1g, [["render", _sfc_render$1g]]);

  const _sfc_main$1f = vue.defineComponent({
    name: "Printer"
  });
  const _hoisted_1$1f = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 768H105.024c-14.272 0-19.456-1.472-24.64-4.288a29.056 29.056 0 01-12.16-12.096C65.536 746.432 64 741.248 64 727.04V379.072c0-42.816 4.48-58.304 12.8-73.984 8.384-15.616 20.672-27.904 36.288-36.288 15.68-8.32 31.168-12.8 73.984-12.8H256V64h512v192h68.928c42.816 0 58.304 4.48 73.984 12.8 15.616 8.384 27.904 20.672 36.288 36.288 8.32 15.68 12.8 31.168 12.8 73.984v347.904c0 14.272-1.472 19.456-4.288 24.64a29.056 29.056 0 01-12.096 12.16c-5.184 2.752-10.368 4.224-24.64 4.224H768v192H256V768zm64-192v320h384V576H320zm-64 128V512h512v192h128V379.072c0-29.376-1.408-36.48-5.248-43.776a23.296 23.296 0 00-10.048-10.048c-7.232-3.84-14.4-5.248-43.776-5.248H187.072c-29.376 0-36.48 1.408-43.776 5.248a23.296 23.296 0 00-10.048 10.048c-3.84 7.232-5.248 14.4-5.248 43.776V704h128zm64-448h384V128H320v128zm-64 128h64v64h-64v-64zm128 0h64v64h-64v-64z"
  }, null, -1);
  const _hoisted_3$1f = [
    _hoisted_2$1f
  ];
  function _sfc_render$1f(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1f, _hoisted_3$1f);
  }
  var printer = /* @__PURE__ */ _export_sfc(_sfc_main$1f, [["render", _sfc_render$1f]]);

  const _sfc_main$1e = vue.defineComponent({
    name: "Promotion"
  });
  const _hoisted_1$1e = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1e = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M64 448l832-320-128 704-446.08-243.328L832 192 242.816 545.472 64 448zm256 512V657.024L512 768 320 960z"
  }, null, -1);
  const _hoisted_3$1e = [
    _hoisted_2$1e
  ];
  function _sfc_render$1e(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1e, _hoisted_3$1e);
  }
  var promotion = /* @__PURE__ */ _export_sfc(_sfc_main$1e, [["render", _sfc_render$1e]]);

  const _sfc_main$1d = vue.defineComponent({
    name: "QuestionFilled"
  });
  const _hoisted_1$1d = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1d = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm23.744 191.488c-52.096 0-92.928 14.784-123.2 44.352-30.976 29.568-45.76 70.4-45.76 122.496h80.256c0-29.568 5.632-52.8 17.6-68.992 13.376-19.712 35.2-28.864 66.176-28.864 23.936 0 42.944 6.336 56.32 19.712 12.672 13.376 19.712 31.68 19.712 54.912 0 17.6-6.336 34.496-19.008 49.984l-8.448 9.856c-45.76 40.832-73.216 70.4-82.368 89.408-9.856 19.008-14.08 42.24-14.08 68.992v9.856h80.96v-9.856c0-16.896 3.52-31.68 10.56-45.76 6.336-12.672 15.488-24.64 28.16-35.2 33.792-29.568 54.208-48.576 60.544-55.616 16.896-22.528 26.048-51.392 26.048-86.592 0-42.944-14.08-76.736-42.24-101.376-28.16-25.344-65.472-37.312-111.232-37.312zm-12.672 406.208a54.272 54.272 0 00-38.72 14.784 49.408 49.408 0 00-15.488 38.016c0 15.488 4.928 28.16 15.488 38.016A54.848 54.848 0 00523.072 768c15.488 0 28.16-4.928 38.72-14.784a51.52 51.52 0 0016.192-38.72 51.968 51.968 0 00-15.488-38.016 55.936 55.936 0 00-39.424-14.784z"
  }, null, -1);
  const _hoisted_3$1d = [
    _hoisted_2$1d
  ];
  function _sfc_render$1d(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1d, _hoisted_3$1d);
  }
  var questionFilled = /* @__PURE__ */ _export_sfc(_sfc_main$1d, [["render", _sfc_render$1d]]);

  const _sfc_main$1c = vue.defineComponent({
    name: "Rank"
  });
  const _hoisted_1$1c = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1c = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M186.496 544l41.408 41.344a32 32 0 11-45.248 45.312l-96-96a32 32 0 010-45.312l96-96a32 32 0 1145.248 45.312L186.496 480h290.816V186.432l-41.472 41.472a32 32 0 11-45.248-45.184l96-96.128a32 32 0 0145.312 0l96 96.064a32 32 0 01-45.248 45.184l-41.344-41.28V480H832l-41.344-41.344a32 32 0 0145.248-45.312l96 96a32 32 0 010 45.312l-96 96a32 32 0 01-45.248-45.312L832 544H541.312v293.44l41.344-41.28a32 32 0 1145.248 45.248l-96 96a32 32 0 01-45.312 0l-96-96a32 32 0 1145.312-45.248l41.408 41.408V544H186.496z"
  }, null, -1);
  const _hoisted_3$1c = [
    _hoisted_2$1c
  ];
  function _sfc_render$1c(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1c, _hoisted_3$1c);
  }
  var rank = /* @__PURE__ */ _export_sfc(_sfc_main$1c, [["render", _sfc_render$1c]]);

  const _sfc_main$1b = vue.defineComponent({
    name: "ReadingLamp"
  });
  const _hoisted_1$1b = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 896h320q32 0 32 32t-32 32H352q-32 0-32-32t32-32zM307.328 128l-99.52 448h608.384l-99.52-448H307.328zm-25.6-64h460.608a32 32 0 0131.232 25.088l113.792 512A32 32 0 01856.128 640H167.872a32 32 0 01-31.232-38.912l113.792-512A32 32 0 01281.664 64z"
  }, null, -1);
  const _hoisted_3$1b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M672 576q32 0 32 32v128q0 32-32 32t-32-32V608q0-32 32-32zM480 575.936h64V960h-64z"
  }, null, -1);
  const _hoisted_4$i = [
    _hoisted_2$1b,
    _hoisted_3$1b
  ];
  function _sfc_render$1b(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1b, _hoisted_4$i);
  }
  var readingLamp = /* @__PURE__ */ _export_sfc(_sfc_main$1b, [["render", _sfc_render$1b]]);

  const _sfc_main$1a = vue.defineComponent({
    name: "Reading"
  });
  const _hoisted_1$1a = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 863.36l384-54.848v-638.72L525.568 222.72a96 96 0 01-27.136 0L128 169.792v638.72l384 54.848zM137.024 106.432l370.432 52.928a32 32 0 009.088 0l370.432-52.928A64 64 0 01960 169.792v638.72a64 64 0 01-54.976 63.36l-388.48 55.488a32 32 0 01-9.088 0l-388.48-55.488A64 64 0 0164 808.512v-638.72a64 64 0 0173.024-63.36z"
  }, null, -1);
  const _hoisted_3$1a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 192h64v704h-64z"
  }, null, -1);
  const _hoisted_4$h = [
    _hoisted_2$1a,
    _hoisted_3$1a
  ];
  function _sfc_render$1a(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1a, _hoisted_4$h);
  }
  var reading = /* @__PURE__ */ _export_sfc(_sfc_main$1a, [["render", _sfc_render$1a]]);

  const _sfc_main$19 = vue.defineComponent({
    name: "RefreshLeft"
  });
  const _hoisted_1$19 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$19 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M289.088 296.704h92.992a32 32 0 010 64H232.96a32 32 0 01-32-32V179.712a32 32 0 0164 0v50.56a384 384 0 01643.84 282.88 384 384 0 01-383.936 384 384 384 0 01-384-384h64a320 320 0 10640 0 320 320 0 00-555.712-216.448z"
  }, null, -1);
  const _hoisted_3$19 = [
    _hoisted_2$19
  ];
  function _sfc_render$19(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$19, _hoisted_3$19);
  }
  var refreshLeft = /* @__PURE__ */ _export_sfc(_sfc_main$19, [["render", _sfc_render$19]]);

  const _sfc_main$18 = vue.defineComponent({
    name: "RefreshRight"
  });
  const _hoisted_1$18 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$18 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M784.512 230.272v-50.56a32 32 0 1164 0v149.056a32 32 0 01-32 32H667.52a32 32 0 110-64h92.992A320 320 0 10524.8 833.152a320 320 0 00320-320h64a384 384 0 01-384 384 384 384 0 01-384-384 384 384 0 01643.712-282.88z"
  }, null, -1);
  const _hoisted_3$18 = [
    _hoisted_2$18
  ];
  function _sfc_render$18(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$18, _hoisted_3$18);
  }
  var refreshRight = /* @__PURE__ */ _export_sfc(_sfc_main$18, [["render", _sfc_render$18]]);

  const _sfc_main$17 = vue.defineComponent({
    name: "Refresh"
  });
  const _hoisted_1$17 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$17 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M771.776 794.88A384 384 0 01128 512h64a320 320 0 00555.712 216.448H654.72a32 32 0 110-64h149.056a32 32 0 0132 32v148.928a32 32 0 11-64 0v-50.56zM276.288 295.616h92.992a32 32 0 010 64H220.16a32 32 0 01-32-32V178.56a32 32 0 0164 0v50.56A384 384 0 01896.128 512h-64a320 320 0 00-555.776-216.384z"
  }, null, -1);
  const _hoisted_3$17 = [
    _hoisted_2$17
  ];
  function _sfc_render$17(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$17, _hoisted_3$17);
  }
  var refresh = /* @__PURE__ */ _export_sfc(_sfc_main$17, [["render", _sfc_render$17]]);

  const _sfc_main$16 = vue.defineComponent({
    name: "Refrigerator"
  });
  const _hoisted_1$16 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$16 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 448h512V160a32 32 0 00-32-32H288a32 32 0 00-32 32v288zm0 64v352a32 32 0 0032 32h448a32 32 0 0032-32V512H256zm32-448h448a96 96 0 0196 96v704a96 96 0 01-96 96H288a96 96 0 01-96-96V160a96 96 0 0196-96zm32 224h64v96h-64v-96zm0 288h64v96h-64v-96z"
  }, null, -1);
  const _hoisted_3$16 = [
    _hoisted_2$16
  ];
  function _sfc_render$16(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$16, _hoisted_3$16);
  }
  var refrigerator = /* @__PURE__ */ _export_sfc(_sfc_main$16, [["render", _sfc_render$16]]);

  const _sfc_main$15 = vue.defineComponent({
    name: "RemoveFilled"
  });
  const _hoisted_1$15 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$15 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zM288 512a38.4 38.4 0 0038.4 38.4h371.2a38.4 38.4 0 000-76.8H326.4A38.4 38.4 0 00288 512z"
  }, null, -1);
  const _hoisted_3$15 = [
    _hoisted_2$15
  ];
  function _sfc_render$15(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$15, _hoisted_3$15);
  }
  var removeFilled = /* @__PURE__ */ _export_sfc(_sfc_main$15, [["render", _sfc_render$15]]);

  const _sfc_main$14 = vue.defineComponent({
    name: "Remove"
  });
  const _hoisted_1$14 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$14 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 480h320a32 32 0 110 64H352a32 32 0 010-64z"
  }, null, -1);
  const _hoisted_3$14 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_4$g = [
    _hoisted_2$14,
    _hoisted_3$14
  ];
  function _sfc_render$14(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$14, _hoisted_4$g);
  }
  var remove = /* @__PURE__ */ _export_sfc(_sfc_main$14, [["render", _sfc_render$14]]);

  const _sfc_main$13 = vue.defineComponent({
    name: "Right"
  });
  const _hoisted_1$13 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$13 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M754.752 480H160a32 32 0 100 64h594.752L521.344 777.344a32 32 0 0045.312 45.312l288-288a32 32 0 000-45.312l-288-288a32 32 0 10-45.312 45.312L754.752 480z"
  }, null, -1);
  const _hoisted_3$13 = [
    _hoisted_2$13
  ];
  function _sfc_render$13(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$13, _hoisted_3$13);
  }
  var right = /* @__PURE__ */ _export_sfc(_sfc_main$13, [["render", _sfc_render$13]]);

  const _sfc_main$12 = vue.defineComponent({
    name: "ScaleToOriginal"
  });
  const _hoisted_1$12 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$12 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M813.176 180.706a60.235 60.235 0 0160.236 60.235v481.883a60.235 60.235 0 01-60.236 60.235H210.824a60.235 60.235 0 01-60.236-60.235V240.94a60.235 60.235 0 0160.236-60.235h602.352zm0-60.235H210.824A120.47 120.47 0 0090.353 240.94v481.883a120.47 120.47 0 00120.47 120.47h602.353a120.47 120.47 0 00120.471-120.47V240.94a120.47 120.47 0 00-120.47-120.47zm-120.47 180.705a30.118 30.118 0 00-30.118 30.118v301.177a30.118 30.118 0 0060.236 0V331.294a30.118 30.118 0 00-30.118-30.118zm-361.412 0a30.118 30.118 0 00-30.118 30.118v301.177a30.118 30.118 0 1060.236 0V331.294a30.118 30.118 0 00-30.118-30.118zM512 361.412a30.118 30.118 0 00-30.118 30.117v30.118a30.118 30.118 0 0060.236 0V391.53A30.118 30.118 0 00512 361.412zM512 512a30.118 30.118 0 00-30.118 30.118v30.117a30.118 30.118 0 0060.236 0v-30.117A30.118 30.118 0 00512 512z"
  }, null, -1);
  const _hoisted_3$12 = [
    _hoisted_2$12
  ];
  function _sfc_render$12(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$12, _hoisted_3$12);
  }
  var scaleToOriginal = /* @__PURE__ */ _export_sfc(_sfc_main$12, [["render", _sfc_render$12]]);

  const _sfc_main$11 = vue.defineComponent({
    name: "School"
  });
  const _hoisted_1$11 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$11 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 128v704h576V128H224zm-32-64h640a32 32 0 0132 32v768a32 32 0 01-32 32H192a32 32 0 01-32-32V96a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$11 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M64 832h896v64H64zm256-640h128v96H320z"
  }, null, -1);
  const _hoisted_4$f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 832h256v-64a128 128 0 10-256 0v64zm128-256a192 192 0 01192 192v128H320V768a192 192 0 01192-192zM320 384h128v96H320zm256-192h128v96H576zm0 192h128v96H576z"
  }, null, -1);
  const _hoisted_5$4 = [
    _hoisted_2$11,
    _hoisted_3$11,
    _hoisted_4$f
  ];
  function _sfc_render$11(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$11, _hoisted_5$4);
  }
  var school = /* @__PURE__ */ _export_sfc(_sfc_main$11, [["render", _sfc_render$11]]);

  const _sfc_main$10 = vue.defineComponent({
    name: "Scissor"
  });
  const _hoisted_1$10 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$10 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512.064 578.368l-106.88 152.768a160 160 0 11-23.36-78.208L472.96 522.56 196.864 128.256a32 32 0 1152.48-36.736l393.024 561.344a160 160 0 11-23.36 78.208l-106.88-152.704zm54.4-189.248l208.384-297.6a32 32 0 0152.48 36.736l-221.76 316.672-39.04-55.808zm-376.32 425.856a96 96 0 10110.144-157.248 96 96 0 00-110.08 157.248zm643.84 0a96 96 0 10-110.08-157.248 96 96 0 00110.08 157.248z"
  }, null, -1);
  const _hoisted_3$10 = [
    _hoisted_2$10
  ];
  function _sfc_render$10(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$10, _hoisted_3$10);
  }
  var scissor = /* @__PURE__ */ _export_sfc(_sfc_main$10, [["render", _sfc_render$10]]);

  const _sfc_main$$ = vue.defineComponent({
    name: "Search"
  });
  const _hoisted_1$$ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$$ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M795.904 750.72l124.992 124.928a32 32 0 01-45.248 45.248L750.656 795.904a416 416 0 1145.248-45.248zM480 832a352 352 0 100-704 352 352 0 000 704z"
  }, null, -1);
  const _hoisted_3$$ = [
    _hoisted_2$$
  ];
  function _sfc_render$$(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$$, _hoisted_3$$);
  }
  var search = /* @__PURE__ */ _export_sfc(_sfc_main$$, [["render", _sfc_render$$]]);

  const _sfc_main$_ = vue.defineComponent({
    name: "Select"
  });
  const _hoisted_1$_ = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$_ = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M77.248 415.04a64 64 0 0190.496 0l226.304 226.304L846.528 188.8a64 64 0 1190.56 90.496l-543.04 543.04-316.8-316.8a64 64 0 010-90.496z"
  }, null, -1);
  const _hoisted_3$_ = [
    _hoisted_2$_
  ];
  function _sfc_render$_(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$_, _hoisted_3$_);
  }
  var select = /* @__PURE__ */ _export_sfc(_sfc_main$_, [["render", _sfc_render$_]]);

  const _sfc_main$Z = vue.defineComponent({
    name: "Sell"
  });
  const _hoisted_1$Z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$Z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 288h131.072a32 32 0 0131.808 28.8L886.4 512h-64.384l-16-160H704v96a32 32 0 11-64 0v-96H384v96a32 32 0 01-64 0v-96H217.92l-51.2 512H512v64H131.328a32 32 0 01-31.808-35.2l57.6-576a32 32 0 0131.808-28.8H320v-22.336C320 154.688 405.504 64 512 64s192 90.688 192 201.664v22.4zm-64 0v-22.336C640 189.248 582.272 128 512 128c-70.272 0-128 61.248-128 137.664v22.4h256zm201.408 483.84L768 698.496V928a32 32 0 11-64 0V698.496l-73.344 73.344a32 32 0 11-45.248-45.248l128-128a32 32 0 0145.248 0l128 128a32 32 0 11-45.248 45.248z"
  }, null, -1);
  const _hoisted_3$Z = [
    _hoisted_2$Z
  ];
  function _sfc_render$Z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$Z, _hoisted_3$Z);
  }
  var sell = /* @__PURE__ */ _export_sfc(_sfc_main$Z, [["render", _sfc_render$Z]]);

  const _sfc_main$Y = vue.defineComponent({
    name: "SemiSelect"
  });
  const _hoisted_1$Y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$Y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 448h768q64 0 64 64t-64 64H128q-64 0-64-64t64-64z"
  }, null, -1);
  const _hoisted_3$Y = [
    _hoisted_2$Y
  ];
  function _sfc_render$Y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$Y, _hoisted_3$Y);
  }
  var semiSelect = /* @__PURE__ */ _export_sfc(_sfc_main$Y, [["render", _sfc_render$Y]]);

  const _sfc_main$X = vue.defineComponent({
    name: "Service"
  });
  const _hoisted_1$X = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$X = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M864 409.6a192 192 0 01-37.888 349.44A256.064 256.064 0 01576 960h-96a32 32 0 110-64h96a192.064 192.064 0 00181.12-128H736a32 32 0 01-32-32V416a32 32 0 0132-32h32c10.368 0 20.544.832 30.528 2.432a288 288 0 00-573.056 0A193.235 193.235 0 01256 384h32a32 32 0 0132 32v320a32 32 0 01-32 32h-32a192 192 0 01-96-358.4 352 352 0 01704 0zM256 448a128 128 0 100 256V448zm640 128a128 128 0 00-128-128v256a128 128 0 00128-128z"
  }, null, -1);
  const _hoisted_3$X = [
    _hoisted_2$X
  ];
  function _sfc_render$X(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$X, _hoisted_3$X);
  }
  var service = /* @__PURE__ */ _export_sfc(_sfc_main$X, [["render", _sfc_render$X]]);

  const _sfc_main$W = vue.defineComponent({
    name: "SetUp"
  });
  const _hoisted_1$W = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$W = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 160a64 64 0 00-64 64v576a64 64 0 0064 64h576a64 64 0 0064-64V224a64 64 0 00-64-64H224zm0-64h576a128 128 0 01128 128v576a128 128 0 01-128 128H224A128 128 0 0196 800V224A128 128 0 01224 96z"
  }, null, -1);
  const _hoisted_3$W = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 416a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256z"
  }, null, -1);
  const _hoisted_4$e = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 320h256q32 0 32 32t-32 32H480q-32 0-32-32t32-32zM640 736a64 64 0 100-128 64 64 0 000 128zm0 64a128 128 0 110-256 128 128 0 010 256z"
  }, null, -1);
  const _hoisted_5$3 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 640h256q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_6 = [
    _hoisted_2$W,
    _hoisted_3$W,
    _hoisted_4$e,
    _hoisted_5$3
  ];
  function _sfc_render$W(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$W, _hoisted_6);
  }
  var setUp = /* @__PURE__ */ _export_sfc(_sfc_main$W, [["render", _sfc_render$W]]);

  const _sfc_main$V = vue.defineComponent({
    name: "Setting"
  });
  const _hoisted_1$V = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$V = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M600.704 64a32 32 0 0130.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0134.432 15.36L944.32 364.8a32 32 0 01-4.032 37.504l-77.12 85.12a357.12 357.12 0 010 49.024l77.12 85.248a32 32 0 014.032 37.504l-88.704 153.6a32 32 0 01-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 01600.704 960H423.296a32 32 0 01-30.464-22.208L357.696 828.48a351.616 351.616 0 01-42.56-24.64l-112.32 24.256a32 32 0 01-34.432-15.36L79.68 659.2a32 32 0 014.032-37.504l77.12-85.248a357.12 357.12 0 010-48.896l-77.12-85.248A32 32 0 0179.68 364.8l88.704-153.6a32 32 0 0134.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 01423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088-24.512 11.968a294.113 294.113 0 00-34.816 20.096l-22.656 15.36-116.224-25.088-65.28 113.152 79.68 88.192-1.92 27.136a293.12 293.12 0 000 40.192l1.92 27.136-79.808 88.192 65.344 113.152 116.224-25.024 22.656 15.296a294.113 294.113 0 0034.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152 24.448-11.904a288.282 288.282 0 0034.752-20.096l22.592-15.296 116.288 25.024 65.28-113.152-79.744-88.192 1.92-27.136a293.12 293.12 0 000-40.256l-1.92-27.136 79.808-88.128-65.344-113.152-116.288 24.96-22.592-15.232a287.616 287.616 0 00-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 110 384 192 192 0 010-384zm0 64a128 128 0 100 256 128 128 0 000-256z"
  }, null, -1);
  const _hoisted_3$V = [
    _hoisted_2$V
  ];
  function _sfc_render$V(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$V, _hoisted_3$V);
  }
  var setting = /* @__PURE__ */ _export_sfc(_sfc_main$V, [["render", _sfc_render$V]]);

  const _sfc_main$U = vue.defineComponent({
    name: "Share"
  });
  const _hoisted_1$U = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$U = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M679.872 348.8l-301.76 188.608a127.808 127.808 0 015.12 52.16l279.936 104.96a128 128 0 11-22.464 59.904l-279.872-104.96a128 128 0 11-16.64-166.272l301.696-188.608a128 128 0 1133.92 54.272z"
  }, null, -1);
  const _hoisted_3$U = [
    _hoisted_2$U
  ];
  function _sfc_render$U(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$U, _hoisted_3$U);
  }
  var share = /* @__PURE__ */ _export_sfc(_sfc_main$U, [["render", _sfc_render$U]]);

  const _sfc_main$T = vue.defineComponent({
    name: "Ship"
  });
  const _hoisted_1$T = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$T = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 386.88V448h405.568a32 32 0 0130.72 40.768l-76.48 267.968A192 192 0 01687.168 896H336.832a192 192 0 01-184.64-139.264L75.648 488.768A32 32 0 01106.368 448H448V117.888a32 32 0 0147.36-28.096l13.888 7.616L512 96v2.88l231.68 126.4a32 32 0 01-2.048 57.216L512 386.88zm0-70.272l144.768-65.792L512 171.84v144.768zM512 512H148.864l18.24 64H856.96l18.24-64H512zM185.408 640l28.352 99.2A128 128 0 00336.832 832h350.336a128 128 0 00123.072-92.8l28.352-99.2H185.408z"
  }, null, -1);
  const _hoisted_3$T = [
    _hoisted_2$T
  ];
  function _sfc_render$T(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$T, _hoisted_3$T);
  }
  var ship = /* @__PURE__ */ _export_sfc(_sfc_main$T, [["render", _sfc_render$T]]);

  const _sfc_main$S = vue.defineComponent({
    name: "Shop"
  });
  const _hoisted_1$S = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$S = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 704h64v192H256V704h64v64h384v-64zm188.544-152.192C894.528 559.616 896 567.616 896 576a96 96 0 11-192 0 96 96 0 11-192 0 96 96 0 11-192 0 96 96 0 11-192 0c0-8.384 1.408-16.384 3.392-24.192L192 128h640l60.544 423.808z"
  }, null, -1);
  const _hoisted_3$S = [
    _hoisted_2$S
  ];
  function _sfc_render$S(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$S, _hoisted_3$S);
  }
  var shop = /* @__PURE__ */ _export_sfc(_sfc_main$S, [["render", _sfc_render$S]]);

  const _sfc_main$R = vue.defineComponent({
    name: "ShoppingBag"
  });
  const _hoisted_1$R = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 320v96a32 32 0 01-32 32h-32V320H384v128h-32a32 32 0 01-32-32v-96H192v576h640V320H704zm-384-64a192 192 0 11384 0h160a32 32 0 0132 32v640a32 32 0 01-32 32H160a32 32 0 01-32-32V288a32 32 0 0132-32h160zm64 0h256a128 128 0 10-256 0z"
  }, null, -1);
  const _hoisted_3$R = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 704h640v64H192z"
  }, null, -1);
  const _hoisted_4$d = [
    _hoisted_2$R,
    _hoisted_3$R
  ];
  function _sfc_render$R(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$R, _hoisted_4$d);
  }
  var shoppingBag = /* @__PURE__ */ _export_sfc(_sfc_main$R, [["render", _sfc_render$R]]);

  const _sfc_main$Q = vue.defineComponent({
    name: "ShoppingCartFull"
  });
  const _hoisted_1$Q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$Q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M432 928a48 48 0 110-96 48 48 0 010 96zm320 0a48 48 0 110-96 48 48 0 010 96zM96 128a32 32 0 010-64h160a32 32 0 0131.36 25.728L320.64 256H928a32 32 0 0131.296 38.72l-96 448A32 32 0 01832 768H384a32 32 0 01-31.36-25.728L229.76 128H96zm314.24 576h395.904l82.304-384H333.44l76.8 384z"
  }, null, -1);
  const _hoisted_3$Q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M699.648 256L608 145.984 516.352 256h183.296zm-140.8-151.04a64 64 0 0198.304 0L836.352 320H379.648l179.2-215.04z"
  }, null, -1);
  const _hoisted_4$c = [
    _hoisted_2$Q,
    _hoisted_3$Q
  ];
  function _sfc_render$Q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$Q, _hoisted_4$c);
  }
  var shoppingCartFull = /* @__PURE__ */ _export_sfc(_sfc_main$Q, [["render", _sfc_render$Q]]);

  const _sfc_main$P = vue.defineComponent({
    name: "ShoppingCart"
  });
  const _hoisted_1$P = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$P = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M432 928a48 48 0 110-96 48 48 0 010 96zm320 0a48 48 0 110-96 48 48 0 010 96zM96 128a32 32 0 010-64h160a32 32 0 0131.36 25.728L320.64 256H928a32 32 0 0131.296 38.72l-96 448A32 32 0 01832 768H384a32 32 0 01-31.36-25.728L229.76 128H96zm314.24 576h395.904l82.304-384H333.44l76.8 384z"
  }, null, -1);
  const _hoisted_3$P = [
    _hoisted_2$P
  ];
  function _sfc_render$P(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$P, _hoisted_3$P);
  }
  var shoppingCart = /* @__PURE__ */ _export_sfc(_sfc_main$P, [["render", _sfc_render$P]]);

  const _sfc_main$O = vue.defineComponent({
    name: "Smoking"
  });
  const _hoisted_1$O = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 576v128h640V576H256zm-32-64h704a32 32 0 0132 32v192a32 32 0 01-32 32H224a32 32 0 01-32-32V544a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$O = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 576h64v128h-64zM256 64h64v320h-64zM128 192h64v192h-64zM64 512h64v256H64z"
  }, null, -1);
  const _hoisted_4$b = [
    _hoisted_2$O,
    _hoisted_3$O
  ];
  function _sfc_render$O(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$O, _hoisted_4$b);
  }
  var smoking = /* @__PURE__ */ _export_sfc(_sfc_main$O, [["render", _sfc_render$O]]);

  const _sfc_main$N = vue.defineComponent({
    name: "Soccer"
  });
  const _hoisted_1$N = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$N = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M418.496 871.04L152.256 604.8c-16.512 94.016-2.368 178.624 42.944 224 44.928 44.928 129.344 58.752 223.296 42.24zm72.32-18.176a573.056 573.056 0 00224.832-137.216 573.12 573.12 0 00137.216-224.832L533.888 171.84a578.56 578.56 0 00-227.52 138.496A567.68 567.68 0 00170.432 532.48l320.384 320.384zM871.04 418.496c16.512-93.952 2.688-178.368-42.24-223.296-44.544-44.544-128.704-58.048-222.592-41.536L871.04 418.496zM149.952 874.048c-112.96-112.96-88.832-408.96 111.168-608.96C461.056 65.152 760.96 36.928 874.048 149.952c113.024 113.024 86.784 411.008-113.152 610.944-199.936 199.936-497.92 226.112-610.944 113.152zm452.544-497.792l22.656-22.656a32 32 0 0145.248 45.248l-22.656 22.656 45.248 45.248A32 32 0 11647.744 512l-45.248-45.248L557.248 512l45.248 45.248a32 32 0 11-45.248 45.248L512 557.248l-45.248 45.248L512 647.744a32 32 0 11-45.248 45.248l-45.248-45.248-22.656 22.656a32 32 0 11-45.248-45.248l22.656-22.656-45.248-45.248A32 32 0 11376.256 512l45.248 45.248L466.752 512l-45.248-45.248a32 32 0 1145.248-45.248L512 466.752l45.248-45.248L512 376.256a32 32 0 0145.248-45.248l45.248 45.248z"
  }, null, -1);
  const _hoisted_3$N = [
    _hoisted_2$N
  ];
  function _sfc_render$N(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$N, _hoisted_3$N);
  }
  var soccer = /* @__PURE__ */ _export_sfc(_sfc_main$N, [["render", _sfc_render$N]]);

  const _sfc_main$M = vue.defineComponent({
    name: "SoldOut"
  });
  const _hoisted_1$M = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$M = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 288h131.072a32 32 0 0131.808 28.8L886.4 512h-64.384l-16-160H704v96a32 32 0 11-64 0v-96H384v96a32 32 0 01-64 0v-96H217.92l-51.2 512H512v64H131.328a32 32 0 01-31.808-35.2l57.6-576a32 32 0 0131.808-28.8H320v-22.336C320 154.688 405.504 64 512 64s192 90.688 192 201.664v22.4zm-64 0v-22.336C640 189.248 582.272 128 512 128c-70.272 0-128 61.248-128 137.664v22.4h256zm201.408 476.16a32 32 0 1145.248 45.184l-128 128a32 32 0 01-45.248 0l-128-128a32 32 0 1145.248-45.248L704 837.504V608a32 32 0 1164 0v229.504l73.408-73.408z"
  }, null, -1);
  const _hoisted_3$M = [
    _hoisted_2$M
  ];
  function _sfc_render$M(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$M, _hoisted_3$M);
  }
  var soldOut = /* @__PURE__ */ _export_sfc(_sfc_main$M, [["render", _sfc_render$M]]);

  const _sfc_main$L = vue.defineComponent({
    name: "SortDown"
  });
  const _hoisted_1$L = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$L = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M576 96v709.568L333.312 562.816A32 32 0 10288 608l297.408 297.344A32 32 0 00640 882.688V96a32 32 0 00-64 0z"
  }, null, -1);
  const _hoisted_3$L = [
    _hoisted_2$L
  ];
  function _sfc_render$L(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$L, _hoisted_3$L);
  }
  var sortDown = /* @__PURE__ */ _export_sfc(_sfc_main$L, [["render", _sfc_render$L]]);

  const _sfc_main$K = vue.defineComponent({
    name: "SortUp"
  });
  const _hoisted_1$K = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$K = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 141.248V928a32 32 0 1064 0V218.56l242.688 242.688A32 32 0 10736 416L438.592 118.656A32 32 0 00384 141.248z"
  }, null, -1);
  const _hoisted_3$K = [
    _hoisted_2$K
  ];
  function _sfc_render$K(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$K, _hoisted_3$K);
  }
  var sortUp = /* @__PURE__ */ _export_sfc(_sfc_main$K, [["render", _sfc_render$K]]);

  const _sfc_main$J = vue.defineComponent({
    name: "Sort"
  });
  const _hoisted_1$J = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$J = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 96a32 32 0 0164 0v786.752a32 32 0 01-54.592 22.656L95.936 608a32 32 0 010-45.312h.128a32 32 0 0145.184 0L384 805.632V96zm192 45.248a32 32 0 0154.592-22.592L928.064 416a32 32 0 010 45.312h-.128a32 32 0 01-45.184 0L640 218.496V928a32 32 0 11-64 0V141.248z"
  }, null, -1);
  const _hoisted_3$J = [
    _hoisted_2$J
  ];
  function _sfc_render$J(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$J, _hoisted_3$J);
  }
  var sort = /* @__PURE__ */ _export_sfc(_sfc_main$J, [["render", _sfc_render$J]]);

  const _sfc_main$I = vue.defineComponent({
    name: "Stamp"
  });
  const _hoisted_1$I = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$I = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M624 475.968V640h144a128 128 0 01128 128H128a128 128 0 01128-128h144V475.968a192 192 0 11224 0zM128 896v-64h768v64H128z"
  }, null, -1);
  const _hoisted_3$I = [
    _hoisted_2$I
  ];
  function _sfc_render$I(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$I, _hoisted_3$I);
  }
  var stamp = /* @__PURE__ */ _export_sfc(_sfc_main$I, [["render", _sfc_render$I]]);

  const _sfc_main$H = vue.defineComponent({
    name: "StarFilled"
  });
  const _hoisted_1$H = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$H = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M283.84 867.84L512 747.776l228.16 119.936a6.4 6.4 0 009.28-6.72l-43.52-254.08 184.512-179.904a6.4 6.4 0 00-3.52-10.88l-255.104-37.12L517.76 147.904a6.4 6.4 0 00-11.52 0L392.192 379.072l-255.104 37.12a6.4 6.4 0 00-3.52 10.88L318.08 606.976l-43.584 254.08a6.4 6.4 0 009.28 6.72z"
  }, null, -1);
  const _hoisted_3$H = [
    _hoisted_2$H
  ];
  function _sfc_render$H(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$H, _hoisted_3$H);
  }
  var starFilled = /* @__PURE__ */ _export_sfc(_sfc_main$H, [["render", _sfc_render$H]]);

  const _sfc_main$G = vue.defineComponent({
    name: "Star"
  });
  const _hoisted_1$G = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$G = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 747.84l228.16 119.936a6.4 6.4 0 009.28-6.72l-43.52-254.08 184.512-179.904a6.4 6.4 0 00-3.52-10.88l-255.104-37.12L517.76 147.904a6.4 6.4 0 00-11.52 0L392.192 379.072l-255.104 37.12a6.4 6.4 0 00-3.52 10.88L318.08 606.976l-43.584 254.08a6.4 6.4 0 009.28 6.72L512 747.84zM313.6 924.48a70.4 70.4 0 01-102.144-74.24l37.888-220.928L88.96 472.96A70.4 70.4 0 01128 352.896l221.76-32.256 99.2-200.96a70.4 70.4 0 01126.208 0l99.2 200.96 221.824 32.256a70.4 70.4 0 0139.04 120.064L774.72 629.376l37.888 220.928a70.4 70.4 0 01-102.144 74.24L512 820.096l-198.4 104.32z"
  }, null, -1);
  const _hoisted_3$G = [
    _hoisted_2$G
  ];
  function _sfc_render$G(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$G, _hoisted_3$G);
  }
  var star = /* @__PURE__ */ _export_sfc(_sfc_main$G, [["render", _sfc_render$G]]);

  const _sfc_main$F = vue.defineComponent({
    name: "Stopwatch"
  });
  const _hoisted_1$F = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$F = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a384 384 0 100-768 384 384 0 000 768zm0 64a448 448 0 110-896 448 448 0 010 896z"
  }, null, -1);
  const _hoisted_3$F = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M672 234.88c-39.168 174.464-80 298.624-122.688 372.48-64 110.848-202.624 30.848-138.624-80C453.376 453.44 540.48 355.968 672 234.816z"
  }, null, -1);
  const _hoisted_4$a = [
    _hoisted_2$F,
    _hoisted_3$F
  ];
  function _sfc_render$F(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$F, _hoisted_4$a);
  }
  var stopwatch = /* @__PURE__ */ _export_sfc(_sfc_main$F, [["render", _sfc_render$F]]);

  const _sfc_main$E = vue.defineComponent({
    name: "SuccessFilled"
  });
  const _hoisted_1$E = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$E = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm-55.808 536.384l-99.52-99.584a38.4 38.4 0 10-54.336 54.336l126.72 126.72a38.272 38.272 0 0054.336 0l262.4-262.464a38.4 38.4 0 10-54.272-54.336L456.192 600.384z"
  }, null, -1);
  const _hoisted_3$E = [
    _hoisted_2$E
  ];
  function _sfc_render$E(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$E, _hoisted_3$E);
  }
  var successFilled = /* @__PURE__ */ _export_sfc(_sfc_main$E, [["render", _sfc_render$E]]);

  const _sfc_main$D = vue.defineComponent({
    name: "Sugar"
  });
  const _hoisted_1$D = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$D = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M801.728 349.184l4.48 4.48a128 128 0 010 180.992L534.656 806.144a128 128 0 01-181.056 0l-4.48-4.48-19.392 109.696a64 64 0 01-108.288 34.176L78.464 802.56a64 64 0 0134.176-108.288l109.76-19.328-4.544-4.544a128 128 0 010-181.056l271.488-271.488a128 128 0 01181.056 0l4.48 4.48 19.392-109.504a64 64 0 01108.352-34.048l142.592 143.04a64 64 0 01-34.24 108.16l-109.248 19.2zm-548.8 198.72h447.168v2.24l60.8-60.8a63.808 63.808 0 0018.752-44.416h-426.88l-89.664 89.728a64.064 64.064 0 00-10.24 13.248zm0 64c2.752 4.736 6.144 9.152 10.176 13.248l135.744 135.744a64 64 0 0090.496 0L638.4 611.904H252.928zm490.048-230.976L625.152 263.104a64 64 0 00-90.496 0L416.768 380.928h326.208zM123.712 757.312l142.976 142.976 24.32-137.6a25.6 25.6 0 00-29.696-29.632l-137.6 24.256zm633.6-633.344l-24.32 137.472a25.6 25.6 0 0029.632 29.632l137.28-24.064-142.656-143.04z"
  }, null, -1);
  const _hoisted_3$D = [
    _hoisted_2$D
  ];
  function _sfc_render$D(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$D, _hoisted_3$D);
  }
  var sugar = /* @__PURE__ */ _export_sfc(_sfc_main$D, [["render", _sfc_render$D]]);

  const _sfc_main$C = vue.defineComponent({
    name: "Suitcase"
  });
  const _hoisted_1$C = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 384h768v-64a64 64 0 00-64-64H192a64 64 0 00-64 64v64zm0 64v320a64 64 0 0064 64h640a64 64 0 0064-64V448H128zm64-256h640a128 128 0 01128 128v448a128 128 0 01-128 128H192A128 128 0 0164 768V320a128 128 0 01128-128z"
  }, null, -1);
  const _hoisted_3$C = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M384 128v64h256v-64H384zm0-64h256a64 64 0 0164 64v64a64 64 0 01-64 64H384a64 64 0 01-64-64v-64a64 64 0 0164-64z"
  }, null, -1);
  const _hoisted_4$9 = [
    _hoisted_2$C,
    _hoisted_3$C
  ];
  function _sfc_render$C(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$C, _hoisted_4$9);
  }
  var suitcase = /* @__PURE__ */ _export_sfc(_sfc_main$C, [["render", _sfc_render$C]]);

  const _sfc_main$B = vue.defineComponent({
    name: "Sunny"
  });
  const _hoisted_1$B = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$B = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 704a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512zM512 64a32 32 0 0132 32v64a32 32 0 01-64 0V96a32 32 0 0132-32zm0 768a32 32 0 0132 32v64a32 32 0 11-64 0v-64a32 32 0 0132-32zM195.2 195.2a32 32 0 0145.248 0l45.248 45.248a32 32 0 11-45.248 45.248L195.2 240.448a32 32 0 010-45.248zm543.104 543.104a32 32 0 0145.248 0l45.248 45.248a32 32 0 01-45.248 45.248l-45.248-45.248a32 32 0 010-45.248zM64 512a32 32 0 0132-32h64a32 32 0 010 64H96a32 32 0 01-32-32zm768 0a32 32 0 0132-32h64a32 32 0 110 64h-64a32 32 0 01-32-32zM195.2 828.8a32 32 0 010-45.248l45.248-45.248a32 32 0 0145.248 45.248L240.448 828.8a32 32 0 01-45.248 0zm543.104-543.104a32 32 0 010-45.248l45.248-45.248a32 32 0 0145.248 45.248l-45.248 45.248a32 32 0 01-45.248 0z"
  }, null, -1);
  const _hoisted_3$B = [
    _hoisted_2$B
  ];
  function _sfc_render$B(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$B, _hoisted_3$B);
  }
  var sunny = /* @__PURE__ */ _export_sfc(_sfc_main$B, [["render", _sfc_render$B]]);

  const _sfc_main$A = vue.defineComponent({
    name: "Sunrise"
  });
  const _hoisted_1$A = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$A = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M32 768h960a32 32 0 110 64H32a32 32 0 110-64zM161.408 672a352 352 0 01701.184 0h-64.32a288 288 0 00-572.544 0h-64.32zM512 128a32 32 0 0132 32v96a32 32 0 01-64 0v-96a32 32 0 0132-32zm407.296 168.704a32 32 0 010 45.248l-67.84 67.84a32 32 0 11-45.248-45.248l67.84-67.84a32 32 0 0145.248 0zm-814.592 0a32 32 0 0145.248 0l67.84 67.84a32 32 0 11-45.248 45.248l-67.84-67.84a32 32 0 010-45.248z"
  }, null, -1);
  const _hoisted_3$A = [
    _hoisted_2$A
  ];
  function _sfc_render$A(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$A, _hoisted_3$A);
  }
  var sunrise = /* @__PURE__ */ _export_sfc(_sfc_main$A, [["render", _sfc_render$A]]);

  const _sfc_main$z = vue.defineComponent({
    name: "Sunset"
  });
  const _hoisted_1$z = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$z = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M82.56 640a448 448 0 11858.88 0h-67.2a384 384 0 10-724.288 0H82.56zM32 704h960q32 0 32 32t-32 32H32q-32 0-32-32t32-32zM288 832h448q32 0 32 32t-32 32H288q-32 0-32-32t32-32z"
  }, null, -1);
  const _hoisted_3$z = [
    _hoisted_2$z
  ];
  function _sfc_render$z(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$z, _hoisted_3$z);
  }
  var sunset = /* @__PURE__ */ _export_sfc(_sfc_main$z, [["render", _sfc_render$z]]);

  const _sfc_main$y = vue.defineComponent({
    name: "SwitchButton"
  });
  const _hoisted_1$y = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M352 159.872V230.4a352 352 0 10320 0v-70.528A416.128 416.128 0 01512 960a416 416 0 01-160-800.128z"
  }, null, -1);
  const _hoisted_3$y = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64q32 0 32 32v320q0 32-32 32t-32-32V96q0-32 32-32z"
  }, null, -1);
  const _hoisted_4$8 = [
    _hoisted_2$y,
    _hoisted_3$y
  ];
  function _sfc_render$y(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$y, _hoisted_4$8);
  }
  var switchButton = /* @__PURE__ */ _export_sfc(_sfc_main$y, [["render", _sfc_render$y]]);

  const _sfc_main$x = vue.defineComponent({
    name: "Switch"
  });
  const _hoisted_1$x = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$x = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M118.656 438.656a32 32 0 010-45.248L416 96l4.48-3.776A32 32 0 01461.248 96l3.712 4.48a32.064 32.064 0 01-3.712 40.832L218.56 384H928a32 32 0 110 64H141.248a32 32 0 01-22.592-9.344zM64 608a32 32 0 0132-32h786.752a32 32 0 0122.656 54.592L608 928l-4.48 3.776a32.064 32.064 0 01-40.832-49.024L805.632 640H96a32 32 0 01-32-32z"
  }, null, -1);
  const _hoisted_3$x = [
    _hoisted_2$x
  ];
  function _sfc_render$x(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$x, _hoisted_3$x);
  }
  var _switch = /* @__PURE__ */ _export_sfc(_sfc_main$x, [["render", _sfc_render$x]]);

  const _sfc_main$w = vue.defineComponent({
    name: "TakeawayBox"
  });
  const _hoisted_1$w = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$w = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M832 384H192v448h640V384zM96 320h832V128H96v192zm800 64v480a32 32 0 01-32 32H160a32 32 0 01-32-32V384H64a32 32 0 01-32-32V96a32 32 0 0132-32h896a32 32 0 0132 32v256a32 32 0 01-32 32h-64zM416 512h192a32 32 0 010 64H416a32 32 0 010-64z"
  }, null, -1);
  const _hoisted_3$w = [
    _hoisted_2$w
  ];
  function _sfc_render$w(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$w, _hoisted_3$w);
  }
  var takeawayBox = /* @__PURE__ */ _export_sfc(_sfc_main$w, [["render", _sfc_render$w]]);

  const _sfc_main$v = vue.defineComponent({
    name: "Ticket"
  });
  const _hoisted_1$v = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$v = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 832H64V640a128 128 0 100-256V192h576v160h64V192h256v192a128 128 0 100 256v192H704V672h-64v160zm0-416v192h64V416h-64z"
  }, null, -1);
  const _hoisted_3$v = [
    _hoisted_2$v
  ];
  function _sfc_render$v(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$v, _hoisted_3$v);
  }
  var ticket = /* @__PURE__ */ _export_sfc(_sfc_main$v, [["render", _sfc_render$v]]);

  const _sfc_main$u = vue.defineComponent({
    name: "Tickets"
  });
  const _hoisted_1$u = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$u = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M192 128v768h640V128H192zm-32-64h704a32 32 0 0132 32v832a32 32 0 01-32 32H160a32 32 0 01-32-32V96a32 32 0 0132-32zm160 448h384v64H320v-64zm0-192h192v64H320v-64zm0 384h384v64H320v-64z"
  }, null, -1);
  const _hoisted_3$u = [
    _hoisted_2$u
  ];
  function _sfc_render$u(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$u, _hoisted_3$u);
  }
  var tickets = /* @__PURE__ */ _export_sfc(_sfc_main$u, [["render", _sfc_render$u]]);

  const _sfc_main$t = vue.defineComponent({
    name: "Timer"
  });
  const _hoisted_1$t = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 896a320 320 0 100-640 320 320 0 000 640zm0 64a384 384 0 110-768 384 384 0 010 768z"
  }, null, -1);
  const _hoisted_3$t = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 320a32 32 0 0132 32l-.512 224a32 32 0 11-64 0L480 352a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4$7 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M448 576a64 64 0 10128 0 64 64 0 10-128 0zM544 128v128h-64V128h-96a32 32 0 010-64h256a32 32 0 110 64h-96z"
  }, null, -1);
  const _hoisted_5$2 = [
    _hoisted_2$t,
    _hoisted_3$t,
    _hoisted_4$7
  ];
  function _sfc_render$t(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$t, _hoisted_5$2);
  }
  var timer = /* @__PURE__ */ _export_sfc(_sfc_main$t, [["render", _sfc_render$t]]);

  const _sfc_main$s = vue.defineComponent({
    name: "ToiletPaper"
  });
  const _hoisted_1$s = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M595.2 128H320a192 192 0 00-192 192v576h384V352c0-90.496 32.448-171.2 83.2-224zM736 64c123.712 0 224 128.96 224 288S859.712 640 736 640H576v320H64V320A256 256 0 01320 64h416zM576 352v224h160c84.352 0 160-97.28 160-224s-75.648-224-160-224-160 97.28-160 224z"
  }, null, -1);
  const _hoisted_3$s = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M736 448c-35.328 0-64-43.008-64-96s28.672-96 64-96 64 43.008 64 96-28.672 96-64 96z"
  }, null, -1);
  const _hoisted_4$6 = [
    _hoisted_2$s,
    _hoisted_3$s
  ];
  function _sfc_render$s(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$s, _hoisted_4$6);
  }
  var toiletPaper = /* @__PURE__ */ _export_sfc(_sfc_main$s, [["render", _sfc_render$s]]);

  const _sfc_main$r = vue.defineComponent({
    name: "Tools"
  });
  const _hoisted_1$r = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$r = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M764.416 254.72a351.68 351.68 0 0186.336 149.184H960v192.064H850.752a351.68 351.68 0 01-86.336 149.312l54.72 94.72-166.272 96-54.592-94.72a352.64 352.64 0 01-172.48 0L371.136 936l-166.272-96 54.72-94.72a351.68 351.68 0 01-86.336-149.312H64v-192h109.248a351.68 351.68 0 0186.336-149.312L204.8 160l166.208-96h.192l54.656 94.592a352.64 352.64 0 01172.48 0L652.8 64h.128L819.2 160l-54.72 94.72zM704 499.968a192 192 0 10-384 0 192 192 0 00384 0z"
  }, null, -1);
  const _hoisted_3$r = [
    _hoisted_2$r
  ];
  function _sfc_render$r(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$r, _hoisted_3$r);
  }
  var tools = /* @__PURE__ */ _export_sfc(_sfc_main$r, [["render", _sfc_render$r]]);

  const _sfc_main$q = vue.defineComponent({
    name: "TopLeft"
  });
  const _hoisted_1$q = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M256 256h416a32 32 0 100-64H224a32 32 0 00-32 32v448a32 32 0 0064 0V256z"
  }, null, -1);
  const _hoisted_3$q = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M246.656 201.344a32 32 0 00-45.312 45.312l544 544a32 32 0 0045.312-45.312l-544-544z"
  }, null, -1);
  const _hoisted_4$5 = [
    _hoisted_2$q,
    _hoisted_3$q
  ];
  function _sfc_render$q(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$q, _hoisted_4$5);
  }
  var topLeft = /* @__PURE__ */ _export_sfc(_sfc_main$q, [["render", _sfc_render$q]]);

  const _sfc_main$p = vue.defineComponent({
    name: "TopRight"
  });
  const _hoisted_1$p = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$p = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 256H353.6a32 32 0 110-64H800a32 32 0 0132 32v448a32 32 0 01-64 0V256z"
  }, null, -1);
  const _hoisted_3$p = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M777.344 201.344a32 32 0 0145.312 45.312l-544 544a32 32 0 01-45.312-45.312l544-544z"
  }, null, -1);
  const _hoisted_4$4 = [
    _hoisted_2$p,
    _hoisted_3$p
  ];
  function _sfc_render$p(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$p, _hoisted_4$4);
  }
  var topRight = /* @__PURE__ */ _export_sfc(_sfc_main$p, [["render", _sfc_render$p]]);

  const _sfc_main$o = vue.defineComponent({
    name: "Top"
  });
  const _hoisted_1$o = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$o = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M572.235 205.282v600.365a30.118 30.118 0 11-60.235 0V205.282L292.382 438.633a28.913 28.913 0 01-42.646 0 33.43 33.43 0 010-45.236l271.058-288.045a28.913 28.913 0 0142.647 0L834.5 393.397a33.43 33.43 0 010 45.176 28.913 28.913 0 01-42.647 0l-219.618-233.23z"
  }, null, -1);
  const _hoisted_3$o = [
    _hoisted_2$o
  ];
  function _sfc_render$o(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$o, _hoisted_3$o);
  }
  var top = /* @__PURE__ */ _export_sfc(_sfc_main$o, [["render", _sfc_render$o]]);

  const _sfc_main$n = vue.defineComponent({
    name: "TrendCharts"
  });
  const _hoisted_1$n = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$n = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 896V128h768v768H128zm291.712-327.296l128 102.4 180.16-201.792-47.744-42.624-139.84 156.608-128-102.4-180.16 201.792 47.744 42.624 139.84-156.608zM816 352a48 48 0 10-96 0 48 48 0 0096 0z"
  }, null, -1);
  const _hoisted_3$n = [
    _hoisted_2$n
  ];
  function _sfc_render$n(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$n, _hoisted_3$n);
  }
  var trendCharts = /* @__PURE__ */ _export_sfc(_sfc_main$n, [["render", _sfc_render$n]]);

  const _sfc_main$m = vue.defineComponent({
    name: "Trophy"
  });
  const _hoisted_1$m = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$m = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 896V702.08A256.256 256.256 0 01264.064 512h-32.64a96 96 0 01-91.968-68.416L93.632 290.88a76.8 76.8 0 0173.6-98.88H256V96a32 32 0 0132-32h448a32 32 0 0132 32v96h88.768a76.8 76.8 0 0173.6 98.88L884.48 443.52A96 96 0 01792.576 512h-32.64A256.256 256.256 0 01544 702.08V896h128a32 32 0 110 64H352a32 32 0 110-64h128zm224-448V128H320v320a192 192 0 10384 0zm64 0h24.576a32 32 0 0030.656-22.784l45.824-152.768A12.8 12.8 0 00856.768 256H768v192zm-512 0V256h-88.768a12.8 12.8 0 00-12.288 16.448l45.824 152.768A32 32 0 00231.424 448H256z"
  }, null, -1);
  const _hoisted_3$m = [
    _hoisted_2$m
  ];
  function _sfc_render$m(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$m, _hoisted_3$m);
  }
  var trophy = /* @__PURE__ */ _export_sfc(_sfc_main$m, [["render", _sfc_render$m]]);

  const _sfc_main$l = vue.defineComponent({
    name: "TurnOff"
  });
  const _hoisted_1$l = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M329.956 257.138a254.862 254.862 0 000 509.724h364.088a254.862 254.862 0 000-509.724H329.956zm0-72.818h364.088a327.68 327.68 0 110 655.36H329.956a327.68 327.68 0 110-655.36z"
  }, null, -1);
  const _hoisted_3$l = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M329.956 621.227a109.227 109.227 0 100-218.454 109.227 109.227 0 000 218.454zm0 72.817a182.044 182.044 0 110-364.088 182.044 182.044 0 010 364.088z"
  }, null, -1);
  const _hoisted_4$3 = [
    _hoisted_2$l,
    _hoisted_3$l
  ];
  function _sfc_render$l(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$l, _hoisted_4$3);
  }
  var turnOff = /* @__PURE__ */ _export_sfc(_sfc_main$l, [["render", _sfc_render$l]]);

  const _sfc_main$k = vue.defineComponent({
    name: "Umbrella"
  });
  const _hoisted_1$k = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$k = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M320 768a32 32 0 1164 0 64 64 0 00128 0V512H64a448 448 0 11896 0H576v256a128 128 0 11-256 0zm570.688-320a384.128 384.128 0 00-757.376 0h757.376z"
  }, null, -1);
  const _hoisted_3$k = [
    _hoisted_2$k
  ];
  function _sfc_render$k(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$k, _hoisted_3$k);
  }
  var umbrella = /* @__PURE__ */ _export_sfc(_sfc_main$k, [["render", _sfc_render$k]]);

  const _sfc_main$j = vue.defineComponent({
    name: "Unlock"
  });
  const _hoisted_1$j = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M224 448a32 32 0 00-32 32v384a32 32 0 0032 32h576a32 32 0 0032-32V480a32 32 0 00-32-32H224zm0-64h576a96 96 0 0196 96v384a96 96 0 01-96 96H224a96 96 0 01-96-96V480a96 96 0 0196-96z"
  }, null, -1);
  const _hoisted_3$j = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 544a32 32 0 0132 32v192a32 32 0 11-64 0V576a32 32 0 0132-32zM690.304 248.704A192.064 192.064 0 00320 320v64h352l96 38.4V448H256V320a256 256 0 01493.76-95.104l-59.456 23.808z"
  }, null, -1);
  const _hoisted_4$2 = [
    _hoisted_2$j,
    _hoisted_3$j
  ];
  function _sfc_render$j(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$j, _hoisted_4$2);
  }
  var unlock = /* @__PURE__ */ _export_sfc(_sfc_main$j, [["render", _sfc_render$j]]);

  const _sfc_main$i = vue.defineComponent({
    name: "UploadFilled"
  });
  const _hoisted_1$i = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$i = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M544 864V672h128L512 480 352 672h128v192H320v-1.6c-5.376.32-10.496 1.6-16 1.6A240 240 0 0164 624c0-123.136 93.12-223.488 212.608-237.248A239.808 239.808 0 01512 192a239.872 239.872 0 01235.456 194.752c119.488 13.76 212.48 114.112 212.48 237.248a240 240 0 01-240 240c-5.376 0-10.56-1.28-16-1.6v1.6H544z"
  }, null, -1);
  const _hoisted_3$i = [
    _hoisted_2$i
  ];
  function _sfc_render$i(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$i, _hoisted_3$i);
  }
  var uploadFilled = /* @__PURE__ */ _export_sfc(_sfc_main$i, [["render", _sfc_render$i]]);

  const _sfc_main$h = vue.defineComponent({
    name: "Upload"
  });
  const _hoisted_1$h = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$h = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 832h704a32 32 0 110 64H160a32 32 0 110-64zm384-578.304V704h-64V247.296L237.248 490.048 192 444.8 508.8 128l316.8 316.8-45.312 45.248L544 253.696z"
  }, null, -1);
  const _hoisted_3$h = [
    _hoisted_2$h
  ];
  function _sfc_render$h(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$h, _hoisted_3$h);
  }
  var upload = /* @__PURE__ */ _export_sfc(_sfc_main$h, [["render", _sfc_render$h]]);

  const _sfc_main$g = vue.defineComponent({
    name: "UserFilled"
  });
  const _hoisted_1$g = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$g = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M288 320a224 224 0 10448 0 224 224 0 10-448 0zm544 608H160a32 32 0 01-32-32v-96a160 160 0 01160-160h448a160 160 0 01160 160v96a32 32 0 01-32 32z"
  }, null, -1);
  const _hoisted_3$g = [
    _hoisted_2$g
  ];
  function _sfc_render$g(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$g, _hoisted_3$g);
  }
  var userFilled = /* @__PURE__ */ _export_sfc(_sfc_main$g, [["render", _sfc_render$g]]);

  const _sfc_main$f = vue.defineComponent({
    name: "User"
  });
  const _hoisted_1$f = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$f = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 512a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512zm320 320v-96a96 96 0 00-96-96H288a96 96 0 00-96 96v96a32 32 0 11-64 0v-96a160 160 0 01160-160h448a160 160 0 01160 160v96a32 32 0 11-64 0z"
  }, null, -1);
  const _hoisted_3$f = [
    _hoisted_2$f
  ];
  function _sfc_render$f(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$f, _hoisted_3$f);
  }
  var user = /* @__PURE__ */ _export_sfc(_sfc_main$f, [["render", _sfc_render$f]]);

  const _sfc_main$e = vue.defineComponent({
    name: "Van"
  });
  const _hoisted_1$e = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$e = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128.896 736H96a32 32 0 01-32-32V224a32 32 0 0132-32h576a32 32 0 0132 32v96h164.544a32 32 0 0131.616 27.136l54.144 352A32 32 0 01922.688 736h-91.52a144 144 0 11-286.272 0H415.104a144 144 0 11-286.272 0zm23.36-64a143.872 143.872 0 01239.488 0H568.32c17.088-25.6 42.24-45.376 71.744-55.808V256H128v416h24.256zm655.488 0h77.632l-19.648-128H704v64.896A144 144 0 01807.744 672zm48.128-192l-14.72-96H704v96h151.872zM688 832a80 80 0 100-160 80 80 0 000 160zm-416 0a80 80 0 100-160 80 80 0 000 160z"
  }, null, -1);
  const _hoisted_3$e = [
    _hoisted_2$e
  ];
  function _sfc_render$e(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$e, _hoisted_3$e);
  }
  var van = /* @__PURE__ */ _export_sfc(_sfc_main$e, [["render", _sfc_render$e]]);

  const _sfc_main$d = vue.defineComponent({
    name: "VideoCameraFilled"
  });
  const _hoisted_1$d = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$d = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M768 576l192-64v320l-192-64v96a32 32 0 01-32 32H96a32 32 0 01-32-32V480a32 32 0 0132-32h640a32 32 0 0132 32v96zM192 768v64h384v-64H192zm192-480a160 160 0 01320 0 160 160 0 01-320 0zm64 0a96 96 0 10192.064-.064A96 96 0 00448 288zm-320 32a128 128 0 11256.064.064A128 128 0 01128 320zm64 0a64 64 0 10128 0 64 64 0 00-128 0z"
  }, null, -1);
  const _hoisted_3$d = [
    _hoisted_2$d
  ];
  function _sfc_render$d(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$d, _hoisted_3$d);
  }
  var videoCameraFilled = /* @__PURE__ */ _export_sfc(_sfc_main$d, [["render", _sfc_render$d]]);

  const _sfc_main$c = vue.defineComponent({
    name: "VideoCamera"
  });
  const _hoisted_1$c = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$c = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 768V256H128v512h576zm64-416l192-96v512l-192-96v128a32 32 0 01-32 32H96a32 32 0 01-32-32V224a32 32 0 0132-32h640a32 32 0 0132 32v128zm0 71.552v176.896l128 64V359.552l-128 64zM192 320h192v64H192v-64z"
  }, null, -1);
  const _hoisted_3$c = [
    _hoisted_2$c
  ];
  function _sfc_render$c(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$c, _hoisted_3$c);
  }
  var videoCamera = /* @__PURE__ */ _export_sfc(_sfc_main$c, [["render", _sfc_render$c]]);

  const _sfc_main$b = vue.defineComponent({
    name: "VideoPause"
  });
  const _hoisted_1$b = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$b = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm0 832a384 384 0 000-768 384 384 0 000 768zm-96-544q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32zm192 0q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32z"
  }, null, -1);
  const _hoisted_3$b = [
    _hoisted_2$b
  ];
  function _sfc_render$b(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$b, _hoisted_3$b);
  }
  var videoPause = /* @__PURE__ */ _export_sfc(_sfc_main$b, [["render", _sfc_render$b]]);

  const _sfc_main$a = vue.defineComponent({
    name: "VideoPlay"
  });
  const _hoisted_1$a = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$a = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm0 832a384 384 0 000-768 384 384 0 000 768zm-48-247.616L668.608 512 464 375.616v272.768zm10.624-342.656l249.472 166.336a48 48 0 010 79.872L474.624 718.272A48 48 0 01400 678.336V345.6a48 48 0 0174.624-39.936z"
  }, null, -1);
  const _hoisted_3$a = [
    _hoisted_2$a
  ];
  function _sfc_render$a(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$a, _hoisted_3$a);
  }
  var videoPlay = /* @__PURE__ */ _export_sfc(_sfc_main$a, [["render", _sfc_render$a]]);

  const _sfc_main$9 = vue.defineComponent({
    name: "View"
  });
  const _hoisted_1$9 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$9 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 160c320 0 512 352 512 352S832 864 512 864 0 512 0 512s192-352 512-352zm0 64c-225.28 0-384.128 208.064-436.8 288 52.608 79.872 211.456 288 436.8 288 225.28 0 384.128-208.064 436.8-288-52.608-79.872-211.456-288-436.8-288zm0 64a224 224 0 110 448 224 224 0 010-448zm0 64a160.192 160.192 0 00-160 160c0 88.192 71.744 160 160 160s160-71.808 160-160-71.744-160-160-160z"
  }, null, -1);
  const _hoisted_3$9 = [
    _hoisted_2$9
  ];
  function _sfc_render$9(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$9, _hoisted_3$9);
  }
  var view = /* @__PURE__ */ _export_sfc(_sfc_main$9, [["render", _sfc_render$9]]);

  const _sfc_main$8 = vue.defineComponent({
    name: "WalletFilled"
  });
  const _hoisted_1$8 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$8 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M688 512a112 112 0 100 224h208v160H128V352h768v160H688zm32 160h-32a48 48 0 010-96h32a48 48 0 010 96zm-80-544l128 160H384l256-160z"
  }, null, -1);
  const _hoisted_3$8 = [
    _hoisted_2$8
  ];
  function _sfc_render$8(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$8, _hoisted_3$8);
  }
  var walletFilled = /* @__PURE__ */ _export_sfc(_sfc_main$8, [["render", _sfc_render$8]]);

  const _sfc_main$7 = vue.defineComponent({
    name: "Wallet"
  });
  const _hoisted_1$7 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$7 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M640 288h-64V128H128v704h384v32a32 32 0 0032 32H96a32 32 0 01-32-32V96a32 32 0 0132-32h512a32 32 0 0132 32v192z"
  }, null, -1);
  const _hoisted_3$7 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M128 320v512h768V320H128zm-32-64h832a32 32 0 0132 32v576a32 32 0 01-32 32H96a32 32 0 01-32-32V288a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4$1 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M704 640a64 64 0 110-128 64 64 0 010 128z"
  }, null, -1);
  const _hoisted_5$1 = [
    _hoisted_2$7,
    _hoisted_3$7,
    _hoisted_4$1
  ];
  function _sfc_render$7(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$7, _hoisted_5$1);
  }
  var wallet = /* @__PURE__ */ _export_sfc(_sfc_main$7, [["render", _sfc_render$7]]);

  const _sfc_main$6 = vue.defineComponent({
    name: "WarningFilled"
  });
  const _hoisted_1$6 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$6 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm0 192a58.432 58.432 0 00-58.24 63.744l23.36 256.384a35.072 35.072 0 0069.76 0l23.296-256.384A58.432 58.432 0 00512 256zm0 512a51.2 51.2 0 100-102.4 51.2 51.2 0 000 102.4z"
  }, null, -1);
  const _hoisted_3$6 = [
    _hoisted_2$6
  ];
  function _sfc_render$6(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$6, _hoisted_3$6);
  }
  var warningFilled = /* @__PURE__ */ _export_sfc(_sfc_main$6, [["render", _sfc_render$6]]);

  const _sfc_main$5 = vue.defineComponent({
    name: "Warning"
  });
  const _hoisted_1$5 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$5 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 64a448 448 0 110 896 448 448 0 010-896zm0 832a384 384 0 000-768 384 384 0 000 768zm48-176a48 48 0 11-96 0 48 48 0 0196 0zm-48-464a32 32 0 0132 32v288a32 32 0 01-64 0V288a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_3$5 = [
    _hoisted_2$5
  ];
  function _sfc_render$5(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$5, _hoisted_3$5);
  }
  var warning = /* @__PURE__ */ _export_sfc(_sfc_main$5, [["render", _sfc_render$5]]);

  const _sfc_main$4 = vue.defineComponent({
    name: "Watch"
  });
  const _hoisted_1$4 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$4 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M512 768a256 256 0 100-512 256 256 0 000 512zm0 64a320 320 0 110-640 320 320 0 010 640z"
  }, null, -1);
  const _hoisted_3$4 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 352a32 32 0 0132 32v160a32 32 0 01-64 0V384a32 32 0 0132-32z"
  }, null, -1);
  const _hoisted_4 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M480 512h128q32 0 32 32t-32 32H480q-32 0-32-32t32-32zM608 256V128H416v128h-64V64h320v192h-64zM416 768v128h192V768h64v192H352V768h64z"
  }, null, -1);
  const _hoisted_5 = [
    _hoisted_2$4,
    _hoisted_3$4,
    _hoisted_4
  ];
  function _sfc_render$4(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$4, _hoisted_5);
  }
  var watch = /* @__PURE__ */ _export_sfc(_sfc_main$4, [["render", _sfc_render$4]]);

  const _sfc_main$3 = vue.defineComponent({
    name: "Watermelon"
  });
  const _hoisted_1$3 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$3 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M683.072 600.32l-43.648 162.816-61.824-16.512 53.248-198.528L576 493.248l-158.4 158.4-45.248-45.248 158.4-158.4-55.616-55.616-198.528 53.248-16.512-61.824 162.816-43.648L282.752 200A384 384 0 00824 741.248L683.072 600.32zm231.552 141.056a448 448 0 11-632-632l632 632z"
  }, null, -1);
  const _hoisted_3$3 = [
    _hoisted_2$3
  ];
  function _sfc_render$3(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$3, _hoisted_3$3);
  }
  var watermelon = /* @__PURE__ */ _export_sfc(_sfc_main$3, [["render", _sfc_render$3]]);

  const _sfc_main$2 = vue.defineComponent({
    name: "WindPower"
  });
  const _hoisted_1$2 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$2 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M160 64q32 0 32 32v832q0 32-32 32t-32-32V96q0-32 32-32zM576 418.624l128-11.584V168.96l-128-11.52v261.12zm-64 5.824V151.552L320 134.08V160h-64V64l616.704 56.064A96 96 0 01960 215.68v144.64a96 96 0 01-87.296 95.616L256 512V224h64v217.92l192-17.472zm256-23.232l98.88-8.96A32 32 0 00896 360.32V215.68a32 32 0 00-29.12-31.872l-98.88-8.96v226.368z"
  }, null, -1);
  const _hoisted_3$2 = [
    _hoisted_2$2
  ];
  function _sfc_render$2(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$2, _hoisted_3$2);
  }
  var windPower = /* @__PURE__ */ _export_sfc(_sfc_main$2, [["render", _sfc_render$2]]);

  const _sfc_main$1 = vue.defineComponent({
    name: "ZoomIn"
  });
  const _hoisted_1$1 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2$1 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M795.904 750.72l124.992 124.928a32 32 0 01-45.248 45.248L750.656 795.904a416 416 0 1145.248-45.248zM480 832a352 352 0 100-704 352 352 0 000 704zm-32-384v-96a32 32 0 0164 0v96h96a32 32 0 010 64h-96v96a32 32 0 01-64 0v-96h-96a32 32 0 010-64h96z"
  }, null, -1);
  const _hoisted_3$1 = [
    _hoisted_2$1
  ];
  function _sfc_render$1(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1$1, _hoisted_3$1);
  }
  var zoomIn = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["render", _sfc_render$1]]);

  const _sfc_main = vue.defineComponent({
    name: "ZoomOut"
  });
  const _hoisted_1 = {
    class: "icon",
    width: "200",
    height: "200",
    viewBox: "0 0 1024 1024",
    xmlns: "http://www.w3.org/2000/svg"
  };
  const _hoisted_2 = /* @__PURE__ */ vue.createElementVNode("path", {
    fill: "currentColor",
    d: "M795.904 750.72l124.992 124.928a32 32 0 01-45.248 45.248L750.656 795.904a416 416 0 1145.248-45.248zM480 832a352 352 0 100-704 352 352 0 000 704zM352 448h256a32 32 0 010 64H352a32 32 0 010-64z"
  }, null, -1);
  const _hoisted_3 = [
    _hoisted_2
  ];
  function _sfc_render(_ctx, _cache, $props, $setup, $data, $options) {
    return vue.openBlock(), vue.createElementBlock("svg", _hoisted_1, _hoisted_3);
  }
  var zoomOut = /* @__PURE__ */ _export_sfc(_sfc_main, [["render", _sfc_render]]);

  exports.AddLocation = addLocation;
  exports.Aim = aim;
  exports.AlarmClock = alarmClock;
  exports.Apple = apple;
  exports.ArrowDown = arrowDown;
  exports.ArrowDownBold = arrowDownBold;
  exports.ArrowLeft = arrowLeft;
  exports.ArrowLeftBold = arrowLeftBold;
  exports.ArrowRight = arrowRight;
  exports.ArrowRightBold = arrowRightBold;
  exports.ArrowUp = arrowUp;
  exports.ArrowUpBold = arrowUpBold;
  exports.Avatar = avatar;
  exports.Back = back;
  exports.Baseball = baseball;
  exports.Basketball = basketball;
  exports.Bell = bell;
  exports.BellFilled = bellFilled;
  exports.Bicycle = bicycle;
  exports.Bottom = bottom;
  exports.BottomLeft = bottomLeft;
  exports.BottomRight = bottomRight;
  exports.Bowl = bowl;
  exports.Box = box;
  exports.Briefcase = briefcase;
  exports.Brush = brush;
  exports.BrushFilled = brushFilled;
  exports.Burger = burger;
  exports.Calendar = calendar;
  exports.Camera = camera;
  exports.CameraFilled = cameraFilled;
  exports.CaretBottom = caretBottom;
  exports.CaretLeft = caretLeft;
  exports.CaretRight = caretRight;
  exports.CaretTop = caretTop;
  exports.Cellphone = cellphone;
  exports.ChatDotRound = chatDotRound;
  exports.ChatDotSquare = chatDotSquare;
  exports.ChatLineRound = chatLineRound;
  exports.ChatLineSquare = chatLineSquare;
  exports.ChatRound = chatRound;
  exports.ChatSquare = chatSquare;
  exports.Check = check;
  exports.Checked = checked;
  exports.Cherry = cherry;
  exports.Chicken = chicken;
  exports.CircleCheck = circleCheck;
  exports.CircleCheckFilled = circleCheckFilled;
  exports.CircleClose = circleClose;
  exports.CircleCloseFilled = circleCloseFilled;
  exports.CirclePlus = circlePlus;
  exports.CirclePlusFilled = circlePlusFilled;
  exports.Clock = clock;
  exports.Close = close;
  exports.CloseBold = closeBold;
  exports.Cloudy = cloudy;
  exports.Coffee = coffee;
  exports.CoffeeCup = coffeeCup;
  exports.Coin = coin;
  exports.ColdDrink = coldDrink;
  exports.Collection = collection;
  exports.CollectionTag = collectionTag;
  exports.Comment = comment;
  exports.Compass = compass;
  exports.Connection = connection;
  exports.Coordinate = coordinate;
  exports.CopyDocument = copyDocument;
  exports.Cpu = cpu;
  exports.CreditCard = creditCard;
  exports.Crop = crop;
  exports.DArrowLeft = dArrowLeft;
  exports.DArrowRight = dArrowRight;
  exports.DCaret = dCaret;
  exports.DataAnalysis = dataAnalysis;
  exports.DataBoard = dataBoard;
  exports.DataLine = dataLine;
  exports.Delete = _delete;
  exports.DeleteFilled = deleteFilled;
  exports.DeleteLocation = deleteLocation;
  exports.Dessert = dessert;
  exports.Discount = discount;
  exports.Dish = dish;
  exports.DishDot = dishDot;
  exports.Document = document;
  exports.DocumentAdd = documentAdd;
  exports.DocumentChecked = documentChecked;
  exports.DocumentCopy = documentCopy;
  exports.DocumentDelete = documentDelete;
  exports.DocumentRemove = documentRemove;
  exports.Download = download;
  exports.Drizzling = drizzling;
  exports.Edit = edit;
  exports.Eleme = eleme;
  exports.ElemeFilled = elemeFilled;
  exports.Expand = expand;
  exports.Failed = failed;
  exports.Female = female;
  exports.Files = files;
  exports.Film = film;
  exports.Filter = filter;
  exports.Finished = finished;
  exports.FirstAidKit = firstAidKit;
  exports.Flag = flag;
  exports.Fold = fold;
  exports.Folder = folder;
  exports.FolderAdd = folderAdd;
  exports.FolderChecked = folderChecked;
  exports.FolderDelete = folderDelete;
  exports.FolderOpened = folderOpened;
  exports.FolderRemove = folderRemove;
  exports.Food = food;
  exports.Football = football;
  exports.ForkSpoon = forkSpoon;
  exports.Fries = fries;
  exports.FullScreen = fullScreen;
  exports.Goblet = goblet;
  exports.GobletFull = gobletFull;
  exports.GobletSquare = gobletSquare;
  exports.GobletSquareFull = gobletSquareFull;
  exports.Goods = goods;
  exports.GoodsFilled = goodsFilled;
  exports.Grape = grape;
  exports.Grid = grid;
  exports.Guide = guide;
  exports.Headset = headset;
  exports.Help = help;
  exports.HelpFilled = helpFilled;
  exports.Histogram = histogram;
  exports.HomeFilled = homeFilled;
  exports.HotWater = hotWater;
  exports.House = house;
  exports.IceCream = iceCream;
  exports.IceCreamRound = iceCreamRound;
  exports.IceCreamSquare = iceCreamSquare;
  exports.IceDrink = iceDrink;
  exports.IceTea = iceTea;
  exports.InfoFilled = infoFilled;
  exports.Iphone = iphone;
  exports.Key = key;
  exports.KnifeFork = knifeFork;
  exports.Lightning = lightning;
  exports.Link = link;
  exports.List = list;
  exports.Loading = loading;
  exports.Location = location;
  exports.LocationFilled = locationFilled;
  exports.LocationInformation = locationInformation;
  exports.Lock = lock;
  exports.Lollipop = lollipop;
  exports.MagicStick = magicStick;
  exports.Magnet = magnet;
  exports.Male = male;
  exports.Management = management;
  exports.MapLocation = mapLocation;
  exports.Medal = medal;
  exports.Menu = menu;
  exports.Message = message;
  exports.MessageBox = messageBox;
  exports.Mic = mic;
  exports.Microphone = microphone;
  exports.MilkTea = milkTea;
  exports.Minus = minus;
  exports.Money = money;
  exports.Monitor = monitor;
  exports.Moon = moon;
  exports.MoonNight = moonNight;
  exports.More = more;
  exports.MoreFilled = moreFilled;
  exports.MostlyCloudy = mostlyCloudy;
  exports.Mouse = mouse;
  exports.Mug = mug;
  exports.Mute = mute;
  exports.MuteNotification = muteNotification;
  exports.NoSmoking = noSmoking;
  exports.Notebook = notebook;
  exports.Notification = notification;
  exports.Odometer = odometer;
  exports.OfficeBuilding = officeBuilding;
  exports.Open = open;
  exports.Operation = operation;
  exports.Opportunity = opportunity;
  exports.Orange = orange;
  exports.Paperclip = paperclip;
  exports.PartlyCloudy = partlyCloudy;
  exports.Pear = pear;
  exports.Phone = phone;
  exports.PhoneFilled = phoneFilled;
  exports.Picture = picture;
  exports.PictureFilled = pictureFilled;
  exports.PictureRounded = pictureRounded;
  exports.PieChart = pieChart;
  exports.Place = place;
  exports.Platform = platform;
  exports.Plus = plus;
  exports.Pointer = pointer;
  exports.Position = position;
  exports.Postcard = postcard;
  exports.Pouring = pouring;
  exports.Present = present;
  exports.PriceTag = priceTag;
  exports.Printer = printer;
  exports.Promotion = promotion;
  exports.QuestionFilled = questionFilled;
  exports.Rank = rank;
  exports.Reading = reading;
  exports.ReadingLamp = readingLamp;
  exports.Refresh = refresh;
  exports.RefreshLeft = refreshLeft;
  exports.RefreshRight = refreshRight;
  exports.Refrigerator = refrigerator;
  exports.Remove = remove;
  exports.RemoveFilled = removeFilled;
  exports.Right = right;
  exports.ScaleToOriginal = scaleToOriginal;
  exports.School = school;
  exports.Scissor = scissor;
  exports.Search = search;
  exports.Select = select;
  exports.Sell = sell;
  exports.SemiSelect = semiSelect;
  exports.Service = service;
  exports.SetUp = setUp;
  exports.Setting = setting;
  exports.Share = share;
  exports.Ship = ship;
  exports.Shop = shop;
  exports.ShoppingBag = shoppingBag;
  exports.ShoppingCart = shoppingCart;
  exports.ShoppingCartFull = shoppingCartFull;
  exports.Smoking = smoking;
  exports.Soccer = soccer;
  exports.SoldOut = soldOut;
  exports.Sort = sort;
  exports.SortDown = sortDown;
  exports.SortUp = sortUp;
  exports.Stamp = stamp;
  exports.Star = star;
  exports.StarFilled = starFilled;
  exports.Stopwatch = stopwatch;
  exports.SuccessFilled = successFilled;
  exports.Sugar = sugar;
  exports.Suitcase = suitcase;
  exports.Sunny = sunny;
  exports.Sunrise = sunrise;
  exports.Sunset = sunset;
  exports.Switch = _switch;
  exports.SwitchButton = switchButton;
  exports.TakeawayBox = takeawayBox;
  exports.Ticket = ticket;
  exports.Tickets = tickets;
  exports.Timer = timer;
  exports.ToiletPaper = toiletPaper;
  exports.Tools = tools;
  exports.Top = top;
  exports.TopLeft = topLeft;
  exports.TopRight = topRight;
  exports.TrendCharts = trendCharts;
  exports.Trophy = trophy;
  exports.TurnOff = turnOff;
  exports.Umbrella = umbrella;
  exports.Unlock = unlock;
  exports.Upload = upload;
  exports.UploadFilled = uploadFilled;
  exports.User = user;
  exports.UserFilled = userFilled;
  exports.Van = van;
  exports.VideoCamera = videoCamera;
  exports.VideoCameraFilled = videoCameraFilled;
  exports.VideoPause = videoPause;
  exports.VideoPlay = videoPlay;
  exports.View = view;
  exports.Wallet = wallet;
  exports.WalletFilled = walletFilled;
  exports.Warning = warning;
  exports.WarningFilled = warningFilled;
  exports.Watch = watch;
  exports.Watermelon = watermelon;
  exports.WindPower = windPower;
  exports.ZoomIn = zoomIn;
  exports.ZoomOut = zoomOut;

  Object.defineProperty(exports, '__esModule', { value: true });

}));
