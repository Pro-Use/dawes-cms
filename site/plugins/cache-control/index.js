(function() {
  "use strict";
  const CacheControl_vue_vue_type_style_index_0_scoped_5212530e_lang = "";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    if (functionalTemplate) {
      options.functional = true;
    }
    if (scopeId) {
      options._scopeId = "data-v-" + scopeId;
    }
    var hook;
    if (moduleIdentifier) {
      hook = function(context) {
        context = context || this.$vnode && this.$vnode.ssrContext || this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext;
        if (!context && typeof __VUE_SSR_CONTEXT__ !== "undefined") {
          context = __VUE_SSR_CONTEXT__;
        }
        if (injectStyles) {
          injectStyles.call(this, context);
        }
        if (context && context._registeredComponents) {
          context._registeredComponents.add(moduleIdentifier);
        }
      };
      options._ssrRegister = hook;
    } else if (injectStyles) {
      hook = shadowMode ? function() {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        );
      } : injectStyles;
    }
    if (hook) {
      if (options.functional) {
        options._injectStyles = hook;
        var originalRender = options.render;
        options.render = function renderWithStyleInjection(h, context) {
          hook.call(context);
          return originalRender(h, context);
        };
      } else {
        var existing = options.beforeCreate;
        options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
      }
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main = {
    data() {
      return {
        label: null,
        icon: "refresh",
        refreshing: false,
        refreshed: false
      };
    },
    created() {
      this.load().then((response) => {
        this.label = response.label;
      });
    },
    methods: {
      async refresh() {
        this.refreshing = true;
        this.icon = "loader";
        const res = await this.$api.get("/refresh-cache");
        console.log(res);
        this.refreshing = false;
        this.icon = "refresh";
      }
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("section", { staticClass: "k-cache-control-section" }, [_c("header", { staticClass: "k-section-header" }, [_c("h2", { staticClass: "k-headline" }, [_vm._v(_vm._s(_vm.label))])]), _c("k-button", { staticClass: "deploy-btn", attrs: { "size": "xlg", "variant": "filled", "icon": _vm.icon, "disabled": _vm.refreshing }, on: { "click": function($event) {
      return _vm.refresh();
    } } }, [_vm._v(" Refresh Cache ")])], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns,
    false,
    null,
    "5212530e",
    null,
    null
  );
  __component__.options.__file = "/home/rob/Company/Dropbox/RP-Code/studio-bristow/cms/site/plugins/cache-control/src/components/CacheControl.vue";
  const CacheControl = __component__.exports;
  panel.plugin("10pm/cache-control", {
    sections: {
      "cache-control": CacheControl
    }
  });
})();
