import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/quiz-correct.js",
                "resources/js/quiz-drop-audio.js",
                "resources/js/quiz-drop-picture.js",
                "resources/js/answer-drop-picture.js",
                "resources/js/answer-drop-audio.js",
                "resources/js/quiz-select-type.js",
                "resources/js/answer-select-type.js",
                "resources/js/organization-drop-logo.js",
                "resources/js/organization-remove-user.js",
                "resources/js/scenario-remove-quiz.js",
                "resources/js/quiz-remove-answer.js",
                "resources/js/organization-remove-scenario.js",
                "resources/js/permissions-toggle.js",
                "resources/js/toggle-pin-input.js",
                "resources/js/toggle-pin-text.js",
                "resources/js/answer-change-order.js",
            ],
            publicDirectory: "public_html",
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            $: "jQuery",
        },
    },
    server: {
        hmr: {
            host: "localhost",
        },
    },
});
