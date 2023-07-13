<?php

use wcf\system\WCF;

$styleVariables = [
    ['messageSidebarOrientation', 'left', null],
    ['pageLogoWidth', '281', null],
    ['pageLogoHeight', '40', null],
    ['useFluidLayout', '1', null],
    ['wcfButtonBackground', 'rgba(207, 216, 220, 1)', 'rgba(47, 57, 76, 1)'],
    ['wcfButtonBackgroundActive', 'rgba(120, 144, 156, 1)', 'rgba(37, 45, 60, 1)'],
    ['wcfButtonDisabledBackground', 'rgba(223, 223, 223, 1)', 'rgba(38, 39, 42, 1)'],
    ['wcfButtonDisabledText', 'rgba(165, 165, 165, 1)', 'rgba(112, 115, 118, 1)'],
    ['wcfButtonPrimaryBackground', 'rgba(29, 122, 197, 1)', 'rgba(1, 87, 155, 1)'],
    ['wcfButtonPrimaryBackgroundActive', 'rgba(26, 107, 173, 1)', 'rgba(1, 75, 132, 1)'],
    ['wcfButtonPrimaryText', 'rgba(255, 255, 255, 1)', 'rgba(231, 236, 245, 1)'],
    ['wcfButtonPrimaryTextActive', 'rgba(255, 255, 255, 1)', 'rgba(231, 236, 245, 1)'],
    ['wcfButtonText', 'rgba(33, 33, 33, 1)', 'rgba(230, 231, 234, 1)'],
    ['wcfButtonTextActive', 'rgba(255, 255, 255, 1)', 'rgba(230, 231, 234, 1)'],
    ['wcfContentBackground', 'rgba(250, 250, 250, 1)', 'rgba(26, 29, 33, 1)'],
    ['wcfContentBorder', 'rgba(65, 121, 173, 1)', 'rgba(98, 113, 136, 1)'],
    ['wcfContentBorderInner', 'rgba(224, 224, 224, 1)', 'rgba(54, 55, 59, 1)'],
    ['wcfContentContainerBackground', 'rgba(255, 255, 255, 1)', 'rgba(34, 37, 41, 1)'],
    ['wcfContentContainerBorder', 'rgba(236, 241, 247, 1)', 'rgba(54, 55, 59, 1)'],
    ['wcfContentDimmedLink', 'rgba(52, 73, 94, 1)', 'rgba(29, 155, 209, 1)'],
    ['wcfContentDimmedLinkActive', 'rgba(52, 73, 94, 1)', 'rgba(64, 179, 228, 1)'],
    ['wcfContentDimmedText', 'rgba(113, 117, 122, 1)', 'rgba(138, 140, 143, 1)'],
    ['wcfContentHeadlineBorder', 'rgba(238, 238, 238, 1)', 'rgba(54, 55, 59, 1)'],
    ['wcfContentHeadlineLink', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfContentHeadlineLinkActive', 'rgba(58, 58, 61, 1)', 'rgba(158, 158, 158, 1)'],
    ['wcfContentHeadlineText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfContentLink', 'rgba(38, 113, 166, 1)', 'rgba(29, 155, 209, 1)'],
    ['wcfContentLinkActive', 'rgba(22, 81, 124, 1)', 'rgba(64, 179, 228, 1)'],
    ['wcfContentText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfDropdownBackground', 'rgba(255, 255, 255, 1)', 'rgba(34, 37, 41, 1)'],
    ['wcfDropdownBackgroundActive', 'rgba(238, 238, 238, 1)', 'rgba(44, 49, 59, 1)'],
    ['wcfDropdownBorderInner', 'rgba(238, 238, 238, 1)', 'rgba(54, 55, 59, 1)'],
    ['wcfDropdownLink', 'rgba(33, 33, 33, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfDropdownLinkActive', 'rgba(33, 33, 33, 1)', 'rgba(239, 239, 239, 1)'],
    ['wcfDropdownText', 'rgba(33, 33, 33, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfEditorButtonBackground', 'rgba(58, 109, 156, 1)', 'rgba(47, 57, 76, 1)'],
    ['wcfEditorButtonBackgroundActive', 'rgba(36, 66, 95, 1)', 'rgba(37, 45, 60, 1)'],
    ['wcfEditorButtonText', 'rgba(255, 255, 255, 1)', 'rgba(230, 231, 234, 1)'],
    ['wcfEditorButtonTextActive', 'rgba(255, 255, 255, 1)', 'rgba(230, 231, 234, 1)'],
    ['wcfEditorButtonTextDisabled', 'rgba(165, 165, 165, 1)', 'rgba(118, 125, 137, 1)'],
    ['wcfEditorTableBorder', 'rgba(221, 221, 221, 1)', 'rgba(221, 221, 221, 1)'],
    ['wcfFontFamilyFallback', 'system', null],
    ['wcfFontLineHeight', '1.48', null],
    ['wcfFontSizeDefault', '15px', null],
    ['wcfFontSizeHeadline', '18px', null],
    ['wcfFontSizeSection', '23px', null],
    ['wcfFontSizeSmall', '12px', null],
    ['wcfFontSizeTitle', '28px', null],
    ['wcfFooterBackground', 'rgba(58, 109, 156, 1)', 'rgba(30, 39, 52, 1)'],
    ['wcfFooterBoxBackground', 'rgba(236, 239, 241, 1)', 'rgba(26, 34, 45, 1)'],
    ['wcfFooterBoxHeadlineLink', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfFooterBoxHeadlineLinkActive', 'rgba(58, 58, 61, 1)', 'rgba(255, 255, 255, 1)'],
    ['wcfFooterBoxHeadlineText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfFooterBoxLink', 'rgba(38, 113, 166', 'rgba(29, 155, 209, 1)'],
    ['wcfFooterBoxLinkActive', 'rgba(22, 81, 124, 1)', 'rgba(64, 179, 228, 1)'],
    ['wcfFooterBoxText', 'rgba(58, 58, 61, 1)', 'rgba(158, 158, 158, 1)'],
    ['wcfFooterCopyrightBackground', 'rgba(50, 92, 132, 1)', 'rgba(36, 46, 61, 1)'],
    ['wcfFooterCopyrightLink', 'rgba(217, 220, 222, 1)', 'rgba(182, 184, 185, 1)'],
    ['wcfFooterCopyrightLinkActive', 'rgba(255, 255, 255, 1)', 'rgba(217, 220, 222, 1)'],
    ['wcfFooterCopyrightText', 'rgba(217, 220, 222, 1)', 'rgba(182, 184, 185, 1)'],
    ['wcfFooterHeadlineLink', 'rgba(255, 255, 255, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfFooterHeadlineLinkActive', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
    ['wcfFooterHeadlineText', 'rgba(189, 195, 199, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfFooterLink', 'rgba(255, 255, 255, 1)', 'rgba(30, 163, 220, 1)'],
    ['wcfFooterLinkActive', 'rgba(255, 255, 255, 1)', 'rgba(75, 184, 231, 1)'],
    ['wcfFooterText', 'rgba(217, 220, 222, 1)', 'rgba(158, 158, 158, 1)'],
    ['wcfHeaderBackground', 'rgba(58, 109, 156, 1)', 'rgba(30, 39, 52, 1)'],
    ['wcfHeaderText', 'rgba(255, 255, 255, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfHeaderLink', 'rgba(255, 255, 255, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfHeaderLinkActive', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
    ['wcfHeaderMenuBackground', 'rgba(50, 92, 132, 1)', 'rgba(36, 46, 61, 1)'],
    ['wcfHeaderMenuLinkBackground', 'rgba(43, 79, 113, 1)', 'rgba(36, 46, 61, 1)'],
    ['wcfHeaderMenuLinkBackgroundActive', 'rgba(36, 66, 95, 1)', 'rgba(43, 56, 74, 1)'],
    ['wcfHeaderMenuLink', 'rgba(255, 255, 255, 1)', 'rgba(183, 186, 191, 1)'],
    ['wcfHeaderMenuLinkActive', 'rgba(255, 255, 255, 1)', 'rgba(224, 227, 230, 1)'],
    ['wcfHeaderMenuDropdownBackground', 'rgba(36, 66, 95, 1)', 'rgba(43, 56, 74, 1)'],
    ['wcfHeaderMenuDropdownBackgroundActive', 'rgba(65, 121, 173, 1)', 'rgba(38, 49, 64, 1)'],
    ['wcfHeaderMenuDropdownLink', 'rgba(255, 255, 255, 1)', 'rgba(224, 227, 230, 1)'],
    ['wcfHeaderMenuDropdownLinkActive', 'rgba(255, 255, 255, 1)', 'rgba(229, 231, 234, 1)'],
    ['wcfHeaderSearchBoxBackground', 'rgba(50, 92, 132, 1)', 'rgba(36, 46, 61, 1)'],
    ['wcfHeaderSearchBoxBackgroundActive', 'rgba(50, 92, 132, 1)', 'rgba(43, 56, 74, 1)'],
    ['wcfHeaderSearchBoxText', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
    ['wcfHeaderSearchBoxTextActive', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
    ['wcfHeaderSearchBoxPlaceholder', 'rgba(207, 207, 207, 1)', 'rgba(207, 207, 207, 1)'],
    ['wcfHeaderSearchBoxPlaceholderActive', 'rgba(207, 207, 207, 1)', 'rgba(207, 207, 207, 1)'],
    ['wcfInputBackground', 'rgba(241, 246, 251, 1)', 'rgba(26, 29, 33, 1)'],
    ['wcfInputBackgroundActive', 'rgba(241, 246, 251, 1)', 'rgba(26, 29, 33, 1)'],
    ['wcfInputBorder', 'rgba(176, 200, 224, 1)', 'rgba(87, 88, 86, 1)'],
    ['wcfInputBorderActive', 'rgba(41, 128, 185, 1)', 'rgba(173, 174, 175, 1)'],
    ['wcfInputDisabledBackground', 'rgba(245, 245, 245, 1)', 'rgba(34, 37, 41, 1)'],
    ['wcfInputDisabledBorder', 'rgba(174, 176, 179, 1)', 'rgba(56, 56, 57, 1)'],
    ['wcfInputDisabledText', 'rgba(125, 130, 100, 1)', 'rgba(118, 119, 121, 1)'],
    ['wcfInputLabel', 'rgba(59, 109, 169, 1)', 'rgba(144, 164, 174, 1)'],
    ['wcfInputText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfInputTextActive', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfInputPlaceholder', 'rgba(169, 169, 169, 1)', 'rgba(122, 123, 125, 1)'],
    ['wcfInputPlaceholderActive', 'rgba(204, 204, 204, 1)', 'rgba(122, 123, 125, 1)'],
    ['wcfLayoutFixedWidth', '1200px', null],
    ['wcfLayoutMaxWidth', '1400px', null],
    ['wcfLayoutMinWidth', '1000px', null],
    ['wcfNavigationBackground', 'rgba(236, 239, 241, 1)', 'rgba(26, 34, 45, 1)'],
    ['wcfNavigationLink', 'rgba(58, 58, 61, 1)', 'rgba(179, 182, 185, 1)'],
    ['wcfNavigationLinkActive', 'rgba(58, 58, 61, 1)', 'rgba(205, 207, 208, 1)'],
    ['wcfNavigationText', 'rgba(170, 170, 170, 1)', 'rgba(179, 182, 185, 1)'],
    ['wcfSidebarBackground', 'rgba(236, 241, 247, 1)', 'rgba(30, 39, 52, 1)'],
    ['wcfSidebarDimmedLink', 'rgba(58, 58, 61, 1)', 'rgba(29, 155, 209, 1)'],
    ['wcfSidebarDimmedLinkActive', 'rgba(58, 58, 61, 1)', 'rgba(64, 179, 228, 1)'],
    ['wcfSidebarDimmedText', 'rgba(105, 109, 114, 1)', 'rgba(138, 140, 143, 1)'],
    ['wcfSidebarHeadlineLink', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfSidebarHeadlineLinkActive', 'rgba(58, 58, 61, 1)', 'rgba(158, 158, 158, 1)'],
    ['wcfSidebarHeadlineText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfSidebarLink', 'rgba(38, 113, 166, 1)', 'rgba(29, 155, 209, 1)'],
    ['wcfSidebarLinkActive', 'rgba(22, 81, 124, 1)', 'rgba(64, 179, 228, 1)'],
    ['wcfSidebarText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfStatusErrorBackground', 'rgba(242, 222, 222, 1)', 'rgba(116, 38, 30, 1)'],
    ['wcfStatusErrorBorder', 'rgba(235, 204, 204, 1)', 'rgba(139, 46, 36, 1)'],
    ['wcfStatusErrorLink', 'rgba(132, 53, 52, 1)', 'rgba(201, 170, 165, 1)'],
    ['wcfStatusErrorLinkActive', 'rgba(132, 53, 52, 1)', 'rgba(201, 170, 165, 1)'],
    ['wcfStatusErrorText', 'rgba(169, 68, 66, 1)', 'rgba(201, 170, 165, 1)'],
    ['wcfStatusInfoBackground', 'rgba(217, 237, 247, 1)', 'rgba(12, 81, 92, 1)'],
    ['wcfStatusInfoBorder', 'rgba(188, 223, 241, 1)', 'rgba(14, 97, 110, 1)'],
    ['wcfStatusInfoLink', 'rgba(36, 82, 105, 1)', 'rgba(171, 191, 196, 1)'],
    ['wcfStatusInfoLinkActive', 'rgba(36, 82, 105, 1)', 'rgba(171, 191, 196, 1)'],
    ['wcfStatusInfoText', 'rgba(49, 112, 143, 1)', 'rgba(171, 191, 196, 1)'],
    ['wcfStatusSuccessBackground', 'rgba(223, 240, 216, 1)', 'rgba(0, 94, 70, 1)'],
    ['wcfStatusSuccessBorder', 'rgba(208, 233, 198, 1)', 'rgba(0, 113, 84, 1)'],
    ['wcfStatusSuccessLink', 'rgba(43, 84, 44, 1)', 'rgba(180, 203, 195, 1)'],
    ['wcfStatusSuccessLinkActive', 'rgba(43, 84, 44, 1)', 'rgba(180, 203, 195, 1)'],
    ['wcfStatusSuccessText', 'rgba(60, 118, 61, 1)', 'rgba(180, 203, 195, 1)'],
    ['wcfStatusWarningBackground', 'rgba(252, 248, 227, 1)', 'rgba(122, 78, 9, 1)'],
    ['wcfStatusWarningBorder', 'rgba(250, 242, 204, 1)', 'rgba(146, 94, 11, 1)'],
    ['wcfStatusWarningLink', 'rgba(102, 81, 44, 1)', 'rgba(221, 209, 194, 1)'],
    ['wcfStatusWarningLinkActive', 'rgba(102, 81, 44, 1)', 'rgba(221, 209, 194, 1)'],
    ['wcfStatusWarningText', 'rgba(138, 109, 59, 1)', 'rgba(221, 209, 194, 1)'],
    ['wcfTabularBoxBackgroundActive', 'rgba(242, 242, 242, 1)', 'rgba(30, 33, 36, 1)'],
    ['wcfTabularBoxBorderInner', 'rgba(238, 238, 238, 1)', 'rgba(54, 55, 59, 1)'],
    ['wcfTabularBoxHeadline', 'rgba(38, 113, 166, 1)', 'rgba(29, 155, 209, 1)'],
    ['wcfTabularBoxHeadlineActive', 'rgba(22, 81, 124, 1)', 'rgba(64, 179, 228, 1)'],
    ['wcfTextShadowDark', 'rgba(0, 0, 0, .8)', 'rgba(0, 0, 0, .8)'],
    ['wcfTextShadowLight', 'rgba(255, 255, 255, .8)', 'rgba(255, 255, 255, .8)'],
    ['wcfTooltipBackground', 'rgba(0, 0, 0, .8)', 'rgba(0, 0, 0, .8)'],
    ['wcfTooltipText', 'rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
    ['wcfUserMenuBackground', 'rgba(255, 255, 255, 1)', 'rgba(34, 37, 41, 1)'],
    ['wcfUserMenuBackgroundActive', 'rgba(239, 239, 239, 1)', 'rgba(44, 49, 59, 1)'],
    ['wcfUserMenuText', 'rgba(58, 58, 61, 1)', 'rgba(209, 210, 211, 1)'],
    ['wcfUserMenuTextActive', 'rgba(58, 58, 61, 1)', 'rgba(239, 239, 239, 1)'],
    ['wcfUserMenuTextDimmed', 'rgba(108, 108, 108, 1)', 'rgba(149, 152, 156, 1)'],
    ['wcfUserMenuIndicator', 'rgba(49, 138, 220, 1)', 'rgba(49, 138, 220, 1)'],
    ['wcfUserMenuBorder', 'rgba(221, 221, 221, 1)', 'rgba(54, 55, 59, 1)'],
    ['wcfSidebarBorder', 'rgba(236, 241, 247, 0)', 'rgba(57, 65, 77, 1)'],
    ['individualScssDarkMode', '', ''],
    ['wcfHeaderMenuDropdownBorder', 'rgba(36, 66, 95, 1)', 'rgba(36, 66, 95, 1)'],
];

$sql = "INSERT INTO             wcf1_style_variable
                                (variableName, defaultValue, defaultValueDarkMode)
        VALUES                  (?, ?, ?)
        ON DUPLICATE KEY UPDATE defaultValue = VALUES(defaultValue),
                                defaultValueDarkMode = VALUES(defaultValueDarkMode)";
$statement = WCF::getDB()->prepare($sql);

foreach ($styleVariables as $data) {
    [$variableName, $defaultValue, $defaultValueDarkMode] = $data;

    $statement->execute([
        $variableName,
        $defaultValue,
        $defaultValueDarkMode,
    ]);
}
