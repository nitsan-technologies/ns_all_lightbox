# Feature — Lightbox for click-enlarge images

*Status: Done. Code-read; the frontend was not rendered during the 2026-10-14 session. Known issues in
`core.md`.*

## Setup

Either the classic static template "All In One Lightbox/Modalbox" or the site set `nitsan/ns-all-lightbox`.

| Setting | Constant (classic) | Site setting | Default |
|---|---|---|---|
| Include jQuery | `plugin.tx_nsalllightbox.settings.jquery` | `ns_all_lightbox.configuration.jquery` | off |
| Popup max width | `…settings.width` | `…configuration.width` | 1024 |
| Popup max height | `…settings.height` | `…configuration.height` | 768 |
| Library | `…settings.type` | `…configuration.type` | 1 |

Library values: 1 Light Box (lightbox2), 2 Fancy Box (Fancybox 2 + buttons/thumbs/media helpers), 3 Dark Box,
4 Swipe Box, 5 Feather Light (+ gallery).

## Rendering

1. The chosen `TYPO3/<library>.typoscript` sets `lib.contentElement.partialRootPaths.100` to the library's
   partial folder and adds its CSS (`page.includeCSS`) and JS (`page.includeJSFooter`, plus the init scripts
   listed in `architecture.md`) on every page.
2. Core fluid_styled_content then uses the extension's `Media/Type/Image.html`:
   - image with a link → normal typolink (no lightbox);
   - "Enlarge on click" set → `<a>` to a processed image limited to the popup size;
   - otherwise → plain image.
   A `<figcaption>` with the file description follows when the file has one.
3. Library-specific link markup: lightbox2 `rel="lightbox[grup<uid>]"` + `data-title`; Fancybox
   `class="fancybox"` + `data-fancybox-group="fancybox<uid>"` + `title`; Darkbox `href="javascript:;"` +
   `data-darkbox` (image URL) + `data-darkbox-group="darkbox<uid>"` + `data-darkbox-description`; Swipebox
   `class="swipebox"` + `data-title`; Featherlight `class="gallery"` + `data-featherlight` (full-size image URL),
   no title. Only lightbox2, Fancybox and Darkbox group per content element (`data.uid`); Swipebox and
   Featherlight treat all such links on the page as one gallery. Titles come from the file description.
