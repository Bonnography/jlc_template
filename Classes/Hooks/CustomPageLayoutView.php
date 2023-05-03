<?php
namespace Cbw\CbwTemplate\Hooks;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;

class CustomPageLayoutView implements PageLayoutViewDrawItemHookInterface {
    /**
     * Preprocesses the preview rendering of a content element of type "codeblock"
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionality
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     */
    public function preProcess(
        PageLayoutView &$parentObject,
        &$drawItem,
        &$headerContent,
        &$itemContent,
        array &$row
    ) {
        if ($row['CType'] === 'headerimage') {
            if ($row['assets']) {
                $headerContent .= $parentObject->linkEditContent('<strong>Header Image</strong>', $row);
                $fileReferences = BackendUtility::resolveFileReferences('tt_content', 'assets', $row);
                if (!empty($fileReferences)) {
                    $linkedContent = '';
                    foreach ($fileReferences as $fileReference) {
                        $linkedContent .= htmlspecialchars($fileReference->getDescription()) . '<br />';
                    }
                    $itemContent .= $parentObject->linkEditContent($linkedContent, $row);
                    unset($linkedContent);
                }
                $previewImage = "";
                $previewImage .= $parentObject->thumbCode($row, 'tt_content', 'assets') . '<br />';
                $itemContent .= $parentObject->linkEditContent($previewImage, $row);
            }
            $drawItem = false;
        }
//        if ($row['CType'] === 'headerImage') {
//
//            $headerContent = '<strong>' . $row['headline'] . '</strong><br />';
//            $itemContent .= $this->linkEditContent($this->getThumbCodeUnlinked($row, 'tt_content', 'image'), $row) . '<br />';
//
//            $drawItem = false;
//        }
//        if ($row['CType'] === 'textmedia') {
//            $headerContent = '<strong>' . $row['headline'] . '</strong><br />';
//            $itemContent = $parentObject->thumbCode($row, 'tt_content', 'image');
//
//            $drawItem = false;
//        }
    }
    public function linkEditContent($str, $row)
    {
        if ($this->doEdit && $this->getBackendUser()->recordEditAccessInternals('tt_content', $row)) {
            $urlParameters = [
                'edit' => [
                    'tt_content' => [
                        $row['uid'] => 'edit'
                    ]
                ],
                'returnUrl' => GeneralUtility::getIndpEnv('REQUEST_URI') . '#element-tt_content-' . $row['uid']
            ];
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
            $url = (string)$uriBuilder->buildUriFromRoute('record_edit', $urlParameters);
            // Return link
            return '<a href="' . htmlspecialchars($url) . '" title="' . htmlspecialchars($this->getLanguageService()->getLL('edit')) . '">' . $str . '</a>';
        }
        return $str;
    }
    public function getThumbCodeUnlinked($row, $table, $field)
    {
        return BackendUtility::thumbCode($row, $table, $field, '', '', null, 0, '', '', false);
    }
    public function renderText($input)
    {
        $input = strip_tags($input);
        $input = GeneralUtility::fixed_lgd_cs($input, 1500);
        return nl2br(htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8', false));
    }

}