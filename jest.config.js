/** @type {import('ts-jest/dist/types').InitialOptionsTsJest} */
module.exports = {
  preset: 'ts-jest',
  testEnvironment: 'jsdom',
  moduleFileExtensions: ["js", "json", "vue", "ts"],
  transform: {
    "^.+\\.tsx?$": "ts-jest",
    ".*\\.(vue)$": "@vue/vue3-jest"
  },
  testRegex: 'resources/js/tests/.*.spec.ts$'
};