/**
 * Provides the touch-friendly fullscreen main menu.
 *
 * @author Alexander Ebert
 * @copyright 2001-2021 WoltLab GmbH
 * @license GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @module WoltLabSuite/Core/Ui/Page/Menu/Main
 */
define(["require", "exports", "tslib", "./Container", "../../../Language", "../../../Dom/Util"], function (require, exports, tslib_1, Container_1, Language, Util_1) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    exports.PageMenuMain = void 0;
    Container_1 = (0, tslib_1.__importDefault)(Container_1);
    Language = (0, tslib_1.__importStar)(Language);
    Util_1 = (0, tslib_1.__importDefault)(Util_1);
    function normalizeMenuItem(menuItem) {
        const anchor = menuItem.querySelector(".boxMenuLink");
        const title = anchor.querySelector(".boxMenuLinkTitle").textContent;
        let counter = 0;
        const outstandingItems = anchor.querySelector(".boxMenuLinkOutstandingItems");
        if (outstandingItems) {
            counter = +outstandingItems.textContent.replace(/[^0-9]/, "");
        }
        const subMenu = menuItem.querySelector("ol");
        let children = [];
        if (subMenu instanceof HTMLOListElement) {
            children = Array.from(subMenu.children).map((subMenuItem) => {
                return normalizeMenuItem(subMenuItem);
            });
        }
        // `link.href` represents the computed link, not the raw value.
        const href = anchor.getAttribute("href");
        let link = undefined;
        if (href && href !== "#") {
            link = anchor.href;
        }
        const active = menuItem.classList.contains("active");
        return {
            active,
            children,
            counter,
            link,
            title,
        };
    }
    class PageMenuMain {
        constructor() {
            this.mainMenu = document.querySelector(".mainMenu");
            this.container = new Container_1.default(this);
            this.mainMenu.addEventListener("click", (event) => {
                event.preventDefault();
                this.container.toggle();
            });
        }
        getContent() {
            const fragment = document.createDocumentFragment();
            fragment.append(...this.buildMainMenu());
            return fragment;
        }
        getMenuButton() {
            return this.mainMenu;
        }
        buildMainMenu() {
            const menu = this.mainMenu.querySelector(".boxMenu");
            const menuItems = Array.from(menu.children).map((element) => {
                return normalizeMenuItem(element);
            });
            const nav = document.createElement("nav");
            nav.classList.add("pageMenuMainNavigation");
            nav.setAttribute("aria-label", window.PAGE_TITLE);
            nav.setAttribute("role", "navigation");
            nav.append(this.buildMenuItemList(menuItems));
            return [nav];
        }
        buildMenuItemList(menuItems) {
            const list = document.createElement("ul");
            list.classList.add("pageMenuMainItemList");
            menuItems
                .filter((menuItem) => {
                // Remove links that have no target (`#`) and do not contain any children.
                if (!menuItem.link && menuItem.children.length === 0) {
                    return false;
                }
                return true;
            })
                .forEach((menuItem) => {
                list.append(this.buildMenuItem(menuItem));
            });
            return list;
        }
        buildMenuItem(menuItem) {
            const listItem = document.createElement("li");
            listItem.classList.add("pageMenuMainItem");
            if (menuItem.link) {
                const link = document.createElement("a");
                link.classList.add("pageMenuMainItemLink");
                link.href = menuItem.link;
                link.textContent = menuItem.title;
                if (menuItem.active) {
                    link.setAttribute("aria-current", "page");
                }
                listItem.append(link);
            }
            else {
                const label = document.createElement("span");
                label.textContent = menuItem.title;
                listItem.append(label);
            }
            if (menuItem.children.length) {
                listItem.classList.add("pageMenuMainItemExpandable");
                const menuId = Util_1.default.getUniqueId();
                const button = document.createElement("a");
                button.classList.add("pageMenuMainItemToggle");
                button.tabIndex = 0;
                button.setAttribute("role", "button");
                button.setAttribute("aria-expanded", "false");
                button.setAttribute("aria-controls", menuId);
                button.setAttribute("aria-label", Language.get("TODO"));
                button.innerHTML = '<span class="icon icon24 fa-angle-down" aria-hidden="true"></span>';
                const list = this.buildMenuItemList(menuItem.children);
                list.id = menuId;
                list.hidden = true;
                button.addEventListener("click", (event) => {
                    event.preventDefault();
                    this.toggleList(button, list);
                });
                button.addEventListener("keydown", (event) => {
                    if (event.key === "Enter" || event.key === " ") {
                        event.preventDefault();
                        button.click();
                    }
                });
                list.addEventListener("keydown", (event) => {
                    if (event.key === "Escape") {
                        event.preventDefault();
                        event.stopPropagation();
                        this.toggleList(button, list);
                    }
                });
                listItem.append(button, list);
            }
            return listItem;
        }
        toggleList(button, list) {
            if (list.hidden) {
                button.setAttribute("aria-expanded", "true");
                list.hidden = false;
            }
            else {
                button.setAttribute("aria-expanded", "false");
                list.hidden = true;
                if (document.activeElement !== button) {
                    button.focus();
                }
            }
        }
    }
    exports.PageMenuMain = PageMenuMain;
    exports.default = PageMenuMain;
});
