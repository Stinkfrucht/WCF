/**
 * Provides the touch-friendly fullscreen main menu.
 *
 * @author Alexander Ebert
 * @copyright 2001-2021 WoltLab GmbH
 * @license GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @module WoltLabSuite/Core/Ui/Page/Menu/Main
 */

import PageMenuContainer from "./Container";
import { PageMenuProvider } from "./Provider";
import * as Language from "../../../Language";
import DomUtil from "../../../Dom/Util";

type MenuItem = {
  active: boolean;
  children: MenuItem[];
  counter: number;
  link?: string;
  title: string;
};

function normalizeMenuItem(menuItem: HTMLElement): MenuItem {
  const anchor = menuItem.querySelector(".boxMenuLink") as HTMLAnchorElement;
  const title = anchor.querySelector(".boxMenuLinkTitle")!.textContent as string;

  let counter = 0;
  const outstandingItems = anchor.querySelector(".boxMenuLinkOutstandingItems");
  if (outstandingItems) {
    counter = +outstandingItems.textContent!.replace(/[^0-9]/, "");
  }

  const subMenu = menuItem.querySelector("ol");
  let children: MenuItem[] = [];
  if (subMenu instanceof HTMLOListElement) {
    children = Array.from(subMenu.children).map((subMenuItem: HTMLElement) => {
      return normalizeMenuItem(subMenuItem);
    });
  }

  // `link.href` represents the computed link, not the raw value.
  const href = anchor.getAttribute("href");
  let link: string | undefined = undefined;
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

export class PageMenuMain implements PageMenuProvider {
  private readonly container: PageMenuContainer;
  private readonly mainMenu: HTMLElement;

  constructor() {
    this.mainMenu = document.querySelector(".mainMenu")!;

    this.container = new PageMenuContainer(this);

    this.mainMenu.addEventListener("click", (event) => {
      event.preventDefault();

      this.container.toggle();
    });
  }

  getContent(): DocumentFragment {
    const fragment = document.createDocumentFragment();

    fragment.append(...this.buildMainMenu());

    return fragment;
  }

  getMenuButton(): HTMLElement {
    return this.mainMenu;
  }

  private buildMainMenu(): HTMLElement[] {
    const menu = this.mainMenu.querySelector(".boxMenu")!;
    const menuItems: MenuItem[] = Array.from(menu.children).map((element: HTMLElement) => {
      return normalizeMenuItem(element);
    });

    const nav = document.createElement("nav");
    nav.classList.add("pageMenuMainNavigation");
    nav.setAttribute("aria-label", window.PAGE_TITLE);
    nav.setAttribute("role", "navigation");
    nav.append(this.buildMenuItemList(menuItems));

    return [nav];
  }

  private buildMenuItemList(menuItems: MenuItem[]): HTMLUListElement {
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

  private buildMenuItem(menuItem: MenuItem): HTMLLIElement {
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
    } else {
      const label = document.createElement("span");
      label.textContent = menuItem.title;

      listItem.append(label);
    }

    if (menuItem.children.length) {
      listItem.classList.add("pageMenuMainItemExpandable");

      const menuId = DomUtil.getUniqueId();

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

  private toggleList(button: HTMLAnchorElement, list: HTMLUListElement): void {
    if (list.hidden) {
      button.setAttribute("aria-expanded", "true");
      list.hidden = false;
    } else {
      button.setAttribute("aria-expanded", "false");
      list.hidden = true;

      if (document.activeElement !== button) {
        button.focus();
      }
    }
  }
}

export default PageMenuMain;
