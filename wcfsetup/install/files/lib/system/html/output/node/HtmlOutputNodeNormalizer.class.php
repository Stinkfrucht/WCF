<?php

namespace wcf\system\html\output\node;

use wcf\util\DOMUtil;

/**
 * Normalizes HTML generated by earlier version of WoltLab Suite.
 *
 * @author Alexander Ebert
 * @copyright 2001-2023 WoltLab GmbH
 * @license GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @since 6.0
 */
final class HtmlOutputNodeNormalizer
{
    public function normalize(\DOMXPath $xpath): void
    {
        $this->normalizeBr($xpath);

        $candidates = $this->getPossibleSpacerParagraphs($xpath);
        $this->reduceSpacerParagraphs($candidates);
    }

    /**
     * @return list<\DOMElement>
     */
    private function getPossibleSpacerParagraphs(\DOMXpath $xpath): array
    {
        $paragraphs = [];

        foreach ($xpath->query('//p') as $p) {
            \assert($p instanceof \DOMElement);

            if ($p->childNodes->length === 1) {
                $child = $p->childNodes->item(0);
                if ($child->nodeName === 'br') {
                    \assert($child instanceof \DOMElement);

                    if ($child->getAttribute('data-cke-filler') !== 'true') {
                        $paragraphs[] = $p;
                    }
                }
            }
        }

        return $paragraphs;
    }

    /**
     * @param list<\DOMElement> $paragraphs
     * @return void
     */
    private function reduceSpacerParagraphs(array $paragraphs): void
    {
        if ($paragraphs === []) {
            return;
        }

        for ($i = 0, $length = \count($paragraphs); $i < $length; $i++) {
            $candidate = $paragraphs[$i];
            $offset = 0;

            // Searches for adjacent paragraphs.
            while ($i + $offset + 1 < $length) {
                $nextCandidate = $paragraphs[$i + $offset + 1];
                if ($candidate->nextElementSibling !== $nextCandidate) {
                    break;
                }

                $offset++;
            }

            if ($offset === 0) {
                // An offset of 0 means that this is a single paragraph and we
                // can safely remove it.
                $candidate->remove();
            } else {
                // We need to reduce the number of paragraphs by half, unless it
                // is an uneven number in which case we need to remove one
                // additional paragraph.
                $totalNumberOfParagraphs = $offset + 1;
                $numberOfParagraphsToRemove = \ceil($totalNumberOfParagraphs / 2);

                $removeParagraphs = \array_slice($paragraphs, $i, $numberOfParagraphsToRemove);
                foreach ($removeParagraphs as $paragraph) {
                    $paragraph->remove();
                }

                $i += $offset;
            }
        }
    }

    private function normalizeBr(\DOMXpath $xpath): void
    {
        foreach ($xpath->query('//br') as $br) {
            \assert($br instanceof \DOMElement);

            $this->unwrapBr($br);
            $this->removeTrailingBr($br);
        }
    }

    private function unwrapBr(\DOMElement $br): void
    {
        for (;;) {
            if ($br->previousSibling || $br->nextSibling) {
                return;
            }

            $parent = $br->parentNode;
            switch ($parent->nodeName) {
                case "b":
                case "del":
                case "em":
                case "i":
                case "strong":
                case "sub":
                case "sup":
                case "span":
                case "u":
                    $parent->parentNode->insertBefore($br, $parent);
                    $parent->parentNode->removeChild($parent);
                    break;

                default:
                    return;
            }
        }
    }

    private function removeTrailingBr(\DOMElement $br): void
    {
        $paragraphOrTableCell = DOMUtil::closest($br, "p");
        if ($paragraphOrTableCell === null) {
            $paragraphOrTableCell = DOMUtil::closest($br, "td");

            if ($paragraphOrTableCell === null) {
                return;
            }
        }

        if (!DOMUtil::isLastNode($br, $paragraphOrTableCell)) {
            return;
        }

        if ($paragraphOrTableCell->nodeName === "td" || $paragraphOrTableCell->childNodes->length > 1) {
            $br->remove();
        }
    }
}
