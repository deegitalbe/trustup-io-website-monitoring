import { defineConfig, loadEnv } from "vite"; // eslint-disable-line import/no-extraneous-dependencies
import laravel from "laravel-vite-plugin"; // eslint-disable-line import/no-extraneous-dependencies
import fs from "fs";
import { join } from "path";
// import { createVuePlugin } from "vite-plugin-vue2";

const sslPath = (extension) =>
    join(__dirname, "certs", `trustup.io.test.${extension}`);

export default defineConfig(({ command, mode }) => {
    const isLocal = command === "serve";
    const env = { ...process.env, ...loadEnv(mode, process.cwd(), "") };
    const host = env.APP_URL.replace("https://", "");

    return {
        plugins: [
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: true,
            }),
            // createVuePlugin(),
        ],
        server: isLocal
            ? {
                  https: {
                      key: fs.readFileSync(sslPath(`key`)),
                      cert: fs.readFileSync(sslPath(`crt`)),
                  },
                  host: "0.0.0.0",
                  hmr: { host },
              }
            : {},
        resolve: {
            alias: {
                "@": "/resources/js",
            },
        },
        define: {
            "process.env": {},
        },
        optimizeDeps: {
            include: [
                // "@deegital/js-trustup-io-websocket",
            ],
        },
    };
});
