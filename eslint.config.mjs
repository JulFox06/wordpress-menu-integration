import globals from 'globals';
import js from '@eslint/js';
import stylisticJs from '@stylistic/eslint-plugin-js';

const languageOptions = {
  globals: {
    ...globals.browser,
    ...globals.node,
  },
  ecmaVersion: 'latest',
  sourceType: 'module',
  parserOptions: {
    ecmaFeatures: {
      jsx: true,
    },
  },
};

export default [
  {
    ignores: ['.gitignore', 'dist', 'node_modules'],
  },
  js.configs.recommended,
  {
    languageOptions,
    plugins: {
      '@stylistic/js': stylisticJs,
    },
    rules: {
      'no-console': 'warn',
      'sort-imports': 'off',
      '@stylistic/js/indent': ['error', 2, { SwitchCase: 1 }],
      '@stylistic/js/linebreak-style': ['error', 'unix'],
      '@stylistic/js/quotes': ['error', 'single'],
      '@stylistic/js/semi': ['error', 'always'],
      'n/no-unpublished-import': 'off',
      'n/no-unpublished-require': 'off',
      'n/no-missing-import': 'off',
    },
  },
];
