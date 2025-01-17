<?php

namespace wcf\system\bbcode;

use wcf\data\attachment\Attachment;
use wcf\system\message\embedded\object\MessageEmbeddedObjectManager;
use wcf\system\request\LinkHandler;
use wcf\system\style\FontAwesomeIcon;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parses the [attach] bbcode tag.
 *
 * @author Alexander Ebert, Marcel Werk
 * @copyright 2001-2023 WoltLab GmbH
 * @license GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
final class AttachmentBBCode extends AbstractBBCode
{
    /**
     * @inheritDoc
     */
    public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser): string
    {
        $attachmentID = \intval($openingTag['attributes'][0] ?? 0);

        $attachment = $this->getAttachment($attachmentID);
        if ($attachment === null) {
            return StringUtil::getAnchorTag(LinkHandler::getInstance()->getLink('Attachment', [
                'id' => $attachmentID,
            ]));
        }

        $outputType = $parser->getOutputType();

        if ($attachment->showAsImage() && $attachment->canViewPreview() && ($outputType == 'text/html' || $outputType == 'text/simplified-html')) {
            $hasParentLink = false;
            if (!empty($closingTag['__parents'])) {
                /** @var \DOMElement $parent */
                foreach ($closingTag['__parents'] as $parent) {
                    if ($parent->nodeName === 'a') {
                        $hasParentLink = true;
                        break;
                    }
                }
            }

            return $this->showImage(
                $attachment,
                $outputType,
                $openingTag['attributes'],
                $hasParentLink,
            );
        } elseif (\substr($attachment->fileType, 0, 6) === 'video/' && $outputType == 'text/html') {
            return $this->showVideoPlayer($attachment);
        } elseif (\substr($attachment->fileType, 0, 6) === 'audio/' && $outputType == 'text/html') {
            return $this->showAudioPlayer($attachment);
        }

        return StringUtil::getAnchorTag($attachment->getLink(), $attachment->filename);
    }

    private function showImage(Attachment $attachment, string $outputType, array $attributes, bool $hasParentLink): string
    {
        $alignment = $attributes[1] ?? '';
        [$isThumbnail, $width] = $this->getImageStyle($attachment, $outputType, $attributes[2] ?? false);

        if ($isThumbnail) {
            return $this->showImageAsThumbnail(
                $attachment,
                $alignment,
                $hasParentLink,
                $width,
            );
        }

        $class = match ($alignment) {
            "left" => "messageFloatObjectLeft",
            "right" => "messageFloatObjectRight",
            default => ""
        };

        $source = StringUtil::encodeHTML($attachment->getLink());
        $title = StringUtil::encodeHTML($attachment->filename);
        $imageElement = \sprintf(
            '<img src="%s" width="%d" height="%d" alt="" loading="lazy">',
            $source,
            $attachment->width,
            $attachment->height,
        );

        if (!$hasParentLink && ($attachment->width > ATTACHMENT_THUMBNAIL_WIDTH || $attachment->height > ATTACHMENT_THUMBNAIL_HEIGHT)) {
            return \sprintf(
                <<<'HTML'
                    <a href="%s" title="%s" class="embeddedAttachmentLink jsImageViewer %s" style="width: %s">
                        %s
                        <span class="embeddedAttachmentLinkEnlarge">
                            %s
                        </span>
                    </a>
                    HTML,
                $source,
                $title,
                $class,
                $width,
                $imageElement,
                FontAwesomeIcon::fromValues('magnifying-glass')->toHtml(24),
            );
        }

        return \sprintf(
            '<span title="%s" class="%s" style="width: %s">%s</span>',
            $title,
            $class,
            $width,
            $imageElement,
        );
    }

    private function showImageAsThumbnail(Attachment $attachment, string $alignment, bool $hasParentLink, string $width): string
    {
        $enlargeImageControls = \sprintf(
            '<span class="embeddedAttachmentLinkEnlarge">%s</span>',
            FontAwesomeIcon::fromValues('magnifying-glass')->toHtml(24),
        );

        $linkParameters = [
            'object' => $attachment,
        ];
        if ($attachment->hasThumbnail()) {
            $linkParameters['thumbnail'] = 1;
        }

        $class = match ($alignment) {
            "left" => "messageFloatObjectLeft",
            "right" => "messageFloatObjectRight",
            default => ""
        };

        $imageClasses = '';
        if (!$attachment->hasThumbnail()) {
            $imageClasses = 'embeddedAttachmentLink jsResizeImage';
        }

        if ($class && (!$attachment->hasThumbnail() || !$attachment->canDownload())) {
            $imageClasses .= ' ' . $class;
        }

        $imageElement = \sprintf(
            '<img src="%s" class="%s" width="%d" height="%d" alt="" loading="lazy">',
            StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', $linkParameters)),
            $imageClasses,
            $attachment->hasThumbnail() ? $attachment->thumbnailWidth : $attachment->width,
            $attachment->hasThumbnail() ? $attachment->thumbnailHeight : $attachment->height,
        );

        if (!$hasParentLink && $attachment->hasThumbnail() && $attachment->canDownload()) {
            return \sprintf(
                '<a href="%s" title="%s" class="embeddedAttachmentLink jsImageViewer %s" style="width: %s">%s%s</a>',
                StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', ['object' => $attachment])),
                StringUtil::encodeHTML($attachment->filename),
                $class,
                $width,
                $imageElement,
                $enlargeImageControls,
            );
        }

        return \sprintf(
            '<span class="%s" stlye="width: %s">%s%s</span>',
            $class,
            $width,
            $imageElement,
            \str_contains($imageClasses, 'embeddedAttachmentLink') ? $enlargeImageControls : '',
        );
    }

    /**
     * @return array{bool, string}
     */
    private function getImageStyle(Attachment $attachment, string $outputType, mixed $thumbnail): array
    {
        // Always use thumbnails for the simplified HTML output.
        if ($outputType == 'text/simplified-html') {
            return [true, "auto"];
        }

        $isThumbnail = false;
        $width = "auto";

        if (\is_numeric($thumbnail)) {
            if ($thumbnail === 0) {
                $isThumbnail = true;
            } else {
                if ($thumbnail <= $attachment->thumbnailWidth) {
                    $isThumbnail = true;
                    $width = $thumbnail;
                } else {
                    $width = \min($thumbnail, $attachment->width);
                }
            }
        } elseif ($thumbnail === 'false') {
            $isThumbnail = false;
        } elseif ($thumbnail !== false) {
            $isThumbnail = true;
        }

        // Force the use of the thumbnail if the user cannot access the full version.
        if (!$thumbnail && !$attachment->canDownload()) {
            $isThumbnail = true;
            if ($width !== "auto" && $width > $attachment->thumbnailWidth) {
                $width = "auto";
            }
        }

        if (\is_numeric($width)) {
            $width = "{$width}px";
        }

        return [$isThumbnail, $width];
    }

    private function showVideoPlayer(Attachment $attachment): string
    {
        return WCF::getTPL()->fetch('__videoAttachmentBBCode', 'wcf', [
            'attachment' => $attachment,
            'attachmentIdentifier' => StringUtil::getRandomID(),
        ]);
    }

    private function showAudioPlayer(Attachment $attachment): string
    {
        return WCF::getTPL()->fetch('__audioAttachmentBBCode', 'wcf', [
            'attachment' => $attachment,
            'attachmentIdentifier' => StringUtil::getRandomID(),
        ]);
    }

    private function getAttachment(int $attachmentID): ?Attachment
    {
        if (!$attachmentID) {
            return null;
        }

        return MessageEmbeddedObjectManager::getInstance()->getObject(
            'com.woltlab.wcf.attachment',
            $attachmentID
        );
    }
}
