/**
 * Provides the media manager dialog for selecting media for input elements.
 *
 * @author  Matthias Schmidt
 * @copyright 2001-2021 WoltLab GmbH
 * @license GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @woltlabExcludeBundle tiny
 */

import MediaManager from "./Base";
import * as Core from "../../Core";
import { Media, MediaManagerSelectOptions } from "../Data";
import * as DomTraverse from "../../Dom/Traverse";
import * as FileUtil from "../../FileUtil";
import * as Language from "../../Language";
import * as UiDialog from "../../Ui/Dialog";

class MediaManagerSelect extends MediaManager<MediaManagerSelectOptions> {
  protected _activeButton: HTMLElement | null = null;
  protected readonly _buttons: HTMLCollectionOf<HTMLInputElement>;
  protected readonly _storeElements = new WeakMap<HTMLElement, HTMLInputElement>();

  constructor(options: Partial<MediaManagerSelectOptions>) {
    super(options);

    this._buttons = document.getElementsByClassName(
      this._options.buttonClass || "jsMediaSelectButton",
    ) as HTMLCollectionOf<HTMLInputElement>;
    Array.from(this._buttons).forEach((button) => {
      // only consider buttons with a proper store specified
      const store = button.dataset.store;
      if (store) {
        const storeElement = document.getElementById(store) as HTMLInputElement;
        if (storeElement && storeElement.tagName === "INPUT") {
          button.addEventListener("click", (ev) => this._click(ev));

          this._storeElements.set(button, storeElement);

          const removeButton = document.createElement("button");
          removeButton.type = "button";
          removeButton.classList.add("button", "jsTooltip");
          removeButton.title = Language.getPhrase("wcf.global.button.delete");
          removeButton.innerHTML = '<fa-icon name="xmark"></fa-icon>';

          if (button.parentElement!.tagName === "LI") {
            const listItem = document.createElement("li");
            listItem.append(removeButton);

            button.parentElement!.insertAdjacentElement("afterend", listItem);

            if (!storeElement.value) {
              listItem.hidden = true;
            }
          } else {
            button.insertAdjacentElement("afterend", removeButton);

            if (!storeElement.value) {
              removeButton.hidden = true;
            }
          }

          removeButton.addEventListener("click", () => this._removeMedia(button, removeButton));
        }
      }
    });
  }

  protected _addButtonEventListeners(): void {
    super._addButtonEventListeners();

    if (!this._mediaManagerMediaList) return;

    DomTraverse.childrenByTag(this._mediaManagerMediaList, "LI").forEach((listItem) => {
      const chooseIcon = listItem.querySelector(".jsMediaSelectButton");
      if (chooseIcon) {
        chooseIcon.classList.remove("jsMediaSelectButton");
        chooseIcon.addEventListener("click", (ev) => this._chooseMedia(ev));
      }
    });
  }

  /**
   * Handles clicking on a media choose icon.
   */
  protected _chooseMedia(event: Event): void {
    if (this._activeButton === null) {
      throw new Error("Media cannot be chosen if no button is active.");
    }

    const target = event.currentTarget as HTMLElement;

    const media = this._media.get(~~target.dataset.objectId!)!;

    // save selected media in store element
    const input = document.getElementById(this._activeButton.dataset.store!) as HTMLInputElement;
    input.value = media.mediaID.toString();
    Core.triggerEvent(input, "change");

    // display selected media
    const display = this._activeButton.dataset.display;
    if (display) {
      const displayElement = document.getElementById(display);
      if (displayElement) {
        if (media.isImage) {
          const thumbnailLink: string = media.smallThumbnailLink ? media.smallThumbnailLink : media.link;
          const altText: string =
            media.altText && media.altText[window.LANGUAGE_ID] ? media.altText[window.LANGUAGE_ID] : "";
          displayElement.innerHTML = `<img src="${thumbnailLink}" alt="${altText}" />`;
        } else {
          let fileIcon = FileUtil.getIconNameByFilename(media.filename);
          if (fileIcon) {
            fileIcon = "file-" + fileIcon;
          } else {
            fileIcon = "file";
          }

          displayElement.innerHTML = `
            <div class="box48" style="margin-bottom: 10px;">
              <fa-icon size="48" name="${fileIcon}"></fa-icon>
              <div class="containerHeadline">
                <h3>${media.filename}</h3>
                <p>${media.formattedFilesize}</p>
              </div>
            </div>`;
        }
      }
    }

    // show remove button
    if (this._activeButton.parentElement!.tagName === "LI") {
      const removeButton = this._activeButton.parentElement!.nextElementSibling as HTMLLIElement;
      removeButton.hidden = false;
    } else {
      const removeButton = this._activeButton.nextElementSibling as HTMLButtonElement;
      removeButton.hidden = false;
    }

    UiDialog.close(this);
  }

  protected _click(event: Event): void {
    event.preventDefault();
    this._activeButton = event.currentTarget as HTMLInputElement;

    super._click(event);

    if (!this._mediaManagerMediaList) {
      return;
    }

    const storeElement = this._storeElements.get(this._activeButton)!;
    DomTraverse.childrenByTag(this._mediaManagerMediaList, "LI").forEach((listItem) => {
      if (storeElement.value && storeElement.value == listItem.dataset.objectId) {
        listItem.classList.add("jsSelected");
      } else {
        listItem.classList.remove("jsSelected");
      }
    });
  }

  public getMode(): string {
    return "select";
  }

  public setupMediaElement(media: Media, mediaElement: HTMLElement): void {
    super.setupMediaElement(media, mediaElement);

    // add media insertion icon
    const buttons = mediaElement.querySelector("nav.buttonGroupNavigation > ul") as HTMLUListElement;

    const listItem = document.createElement("li");
    listItem.className = "jsMediaSelectButton";
    listItem.dataset.objectId = media.mediaID.toString();
    buttons.appendChild(listItem);

    listItem.innerHTML = `
        <a class="jsTooltip" title="${Language.get("wcf.media.button.select")}">
          <fa-icon name="check"></fa-icon>
          <span class="invisible">${Language.get("wcf.media.button.select")}</span>
        </a>
      `;
  }

  /**
   * Handles clicking on the remove button.
   */
  protected _removeMedia(selectButton: HTMLElement, removeButton: HTMLElement): void {
    if (removeButton.parentElement!.tagName === "LI") {
      removeButton.parentElement!.hidden = true;
    } else {
      removeButton.hidden = true;
    }

    const input = document.getElementById(selectButton.dataset.store!) as HTMLInputElement;
    input.value = "";
    Core.triggerEvent(input, "change");
    const display = selectButton.dataset.display;
    if (display) {
      const displayElement = document.getElementById(display);
      if (displayElement) {
        displayElement.innerHTML = "";
      }
    }
  }
}

export = MediaManagerSelect;
