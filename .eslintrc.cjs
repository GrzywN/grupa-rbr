/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution")

module.exports = {
    root: true,
    extends: [
        "plugin:vue/vue3-essential",
        "eslint:recommended",
        "@vue/eslint-config-typescript",
        "@vue/eslint-config-prettier"
    ],
    ignorePatterns: ["resources/js/ziggy.js", "resources/js/ziggy.d.ts"],
    parserOptions: {
        ecmaVersion: "latest"
    },
    rules: {
        "vue/multi-word-component-names": "off",
        "no-undef": "off"
    }
}
