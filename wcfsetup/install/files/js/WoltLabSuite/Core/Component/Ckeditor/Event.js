define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    exports.listenToCkeditor = exports.dispatchToCkeditor = void 0;
    class EventDispatcher {
        #element;
        constructor(element) {
            this.#element = element;
        }
        insertAttachment(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:insert-attachment" /* EventNames.InsertAttachment */, {
                detail: payload,
            }));
        }
        ready(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:ready" /* EventNames.Ready */, {
                detail: payload,
            }));
        }
        removeAttachment(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:remove-attachment" /* EventNames.RemoveAttachment */, {
                detail: payload,
            }));
        }
        reset(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:reset" /* EventNames.Reset */, {
                detail: payload,
            }));
        }
        setupConfiguration(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:setup-configuration" /* EventNames.SetupConfiguration */, {
                detail: payload,
            }));
        }
        setupFeatures(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:setup-features" /* EventNames.SetupFeatures */, {
                detail: payload,
            }));
        }
        uploadAttachment(payload) {
            this.#element.dispatchEvent(new CustomEvent("ckeditor5:upload-attachment" /* EventNames.UploadAttachment */, {
                detail: payload,
            }));
        }
    }
    class EventListener {
        #element;
        constructor(element) {
            this.#element = element;
        }
        insertAttachment(callback) {
            this.#element.addEventListener("ckeditor5:insert-attachment" /* EventNames.InsertAttachment */, (event) => {
                callback(event.detail);
            });
            return this;
        }
        ready(callback) {
            this.#element.addEventListener("ckeditor5:ready" /* EventNames.Ready */, (event) => {
                callback(event.detail);
            }, { once: true });
            return this;
        }
        removeAttachment(callback) {
            this.#element.addEventListener("ckeditor5:remove-attachment" /* EventNames.RemoveAttachment */, (event) => {
                callback(event.detail);
            });
            return this;
        }
        reset(callback) {
            this.#element.addEventListener("ckeditor5:reset" /* EventNames.Reset */, (event) => {
                callback(event.detail);
            });
            return this;
        }
        setupConfiguration(callback) {
            this.#element.addEventListener("ckeditor5:setup-configuration" /* EventNames.SetupConfiguration */, (event) => {
                callback(event.detail);
            }, { once: true });
            return this;
        }
        setupFeatures(callback) {
            this.#element.addEventListener("ckeditor5:setup-features" /* EventNames.SetupFeatures */, (event) => {
                callback(event.detail);
            }, { once: true });
            return this;
        }
        uploadAttachment(callback) {
            this.#element.addEventListener("ckeditor5:upload-attachment" /* EventNames.UploadAttachment */, (event) => {
                callback(event.detail);
            });
            return this;
        }
    }
    function dispatchToCkeditor(element) {
        return new EventDispatcher(element);
    }
    exports.dispatchToCkeditor = dispatchToCkeditor;
    function listenToCkeditor(element) {
        return new EventListener(element);
    }
    exports.listenToCkeditor = listenToCkeditor;
});
