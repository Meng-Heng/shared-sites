<?php

/*
 * Keyman is copyright (C) SIL Global. MIT License.
 *
 * Created by <Meng-Heng> on 2024-11-04
 *
 * GFM Alerts extension extended from Parsedown.
 */

declare(strict_types=1);

namespace Keyman\Site\Common;

use ParsedownExtra;

class GFMAlerts extends ParsedownExtra
{
    private $icon = array(
        // svg and path
        'important' => '<svg class="octicon octicon-report mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill="purple" d="M0 1.75C0 .784.784 0 1.75 0h12.5C15.216 0 16 .784 16 1.75v9.5A1.75 1.75 0 0 1 14.25 13H8.06l-2.573 2.573A1.458 1.458 0 0 1 3 14.543V13H1.75A1.75 1.75 0 0 1 0 11.25Zm1.75-.25a.25.25 0 0 0-.25.25v9.5c0 .138.112.25.25.25h2a.75.75 0 0 1 .75.75v2.19l2.72-2.72a.749.749 0 0 1 .53-.22h6.5a.25.25 0 0 0 .25-.25v-9.5a.25.25 0 0 0-.25-.25Zm7 2.25v2.5a.75.75 0 0 1-1.5 0v-2.5a.75.75 0 0 1 1.5 0ZM9 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>',
        'note' => '<svg class="octicon octicon-info mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill="#316da9" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13 6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"></path></svg>',
        'tip' => '<svg class="octicon octicon-light-bulb mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill="green" d="M8 1.5c-2.363 0-4 1.69-4 3.75 0 .984.424 1.625.984 2.304l.214.253c.223.264.47.556.673.848.284.411.537.896.621 1.49a.75.75 0 0 1-1.484.211c-.04-.282-.163-.547-.37-.847a8.456 8.456 0 0 0-.542-.68c-.084-.1-.173-.205-.268-.32C3.201 7.75 2.5 6.766 2.5 5.25 2.5 2.31 4.863 0 8 0s5.5 2.31 5.5 5.25c0 1.516-.701 2.5-1.328 3.259-.095.115-.184.22-.268.319-.207.245-.383.453-.541.681-.208.3-.33.565-.37.847a.751.751 0 0 1-1.485-.212c.084-.593.337-1.078.621-1.489.203-.292.45-.584.673-.848.075-.088.147-.173.213-.253.561-.679.985-1.32.985-2.304 0-2.06-1.637-3.75-4-3.75ZM5.75 12h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1 0-1.5ZM6 15.25a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75Z"></path></svg>',
        'caution' => '<svg class="octicon octicon-stop mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill="red" d="M4.47.22A.749.749 0 0 1 5 0h6c.199 0 .389.079.53.22l4.25 4.25c.141.14.22.331.22.53v6a.749.749 0 0 1-.22.53l-4.25 4.25A.749.749 0 0 1 11 16H5a.749.749 0 0 1-.53-.22L.22 11.53A.749.749 0 0 1 0 11V5c0-.199.079-.389.22-.53Zm.84 1.28L1.5 5.31v5.38l3.81 3.81h5.38l3.81-3.81V5.31L10.69 1.5ZM8 4a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"></path></svg>',
        'warning' => '<svg class="octicon octicon-alert mr-2" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill="orange" d="M6.457 1.047c.659-1.234 2.427-1.234 3.086 0l6.082 11.378A1.75 1.75 0 0 1 14.082 15H1.918a1.75 1.75 0 0 1-1.543-2.575Zm1.763.707a.25.25 0 0 0-.44 0L1.698 13.132a.25.25 0 0 0 .22.368h12.164a.25.25 0 0 0 .22-.368Zm.53 3.996v2.5a.75.75 0 0 1-1.5 0v-2.5a.75.75 0 0 1 1.5 0ZM9 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>'
    );

    protected function blockQuote($line) {
        if(!preg_match('/^\>\s*\[\!(IMPORTANT|TIP|NOTE|WARNING|CAUTION)\]/i', $line['text'], $matches)) {
            return parent::blockQuote($line);
        }

        // Fetch The Alert's type and title.
        $alertType = strtolower($matches[1]);
        $alertTitle = ucfirst($alertType);

        if(empty($this->icon[$alertType])) {
            return parent::blockQuote($line);
        }

        $alertTitleHtml = $this->icon[$alertType] . $alertTitle;

        // Formatting:> [!AlertType]
        $block = array(
            // We set isAlert to allow subsequent lines to be part of the alert
            'isAlert' => true,
            'element' => array(
                'name' => 'div',
                'attributes' => array('class' => "markdown-alert markdown-alert-$alertType"),
                'handler' => 'elements',
                'text' => array(
                    array(
                        'name' => 'p',
                        'attributes' => array('class' => "markdown-alert-title title-$alertType"),
                        'rawHtml' => $alertTitleHtml
                    ),
                )
            )
        );
        return $block;
    }

    protected function blockQuoteContinue($line, array $block) {
        // If the block didn't start as an alert, fall through to blockquote handler
        if(!isset($block['isAlert'])) {
            return parent::blockQuoteContinue($line, $block);
        }

        if(!preg_match('/^\>\s(.*)/', $line['text'], $matches)) {
            return;
        }

        // Recognize a new Alert
        if(preg_match('/^\>\s*\[\!(IMPORTANT|TIP|NOTE|WARNING|CAUTION)\]/i', $line['text'])) {
            return;
        }

        // Handles any interruption
        if(isset($block['interrupted'])) {
            return;
        }

        // Continue the Alerts, Formatting: > Content, append a paragraph
        $block['element']['text'][] = [
            'name' => 'p',
            'text' => $matches[1],
        ];

        return $block;
    }
}
