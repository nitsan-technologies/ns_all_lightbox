/**
 * Places the server-rendered premium strip in the site settings editor or the TypoScript Constant Editor.
 */
const SETTINGS_EDITOR_TAG = 'typo3-backend-settings-editor';
const CONSTANT_EDITOR_FORM_ID = 'TypoScriptConstantEditorController';
const STRIP_SELECTOR = '.ns-all-lightbox-premium-strip';

const createStrip = (html) => {
  const template = document.createElement('template');
  template.innerHTML = html;
  return template.content;
};

/**
 * The settings editor renders its categories into the light DOM; the strip is appended to the category
 * header block (headline + description), so it follows the category when search hides it.
 */
export async function insertIntoSettingsCategory(html, categoryKey) {
  await customElements.whenDefined(SETTINGS_EDITOR_TAG);
  const editor = document.querySelector(SETTINGS_EDITOR_TAG);
  if (!editor) {
    return;
  }
  await editor.updateComplete;

  const place = () => {
    if (editor.querySelector(STRIP_SELECTOR)) {
      return;
    }
    const category = editor.querySelector(`.settings-category[data-key="${CSS.escape(categoryKey)}"]`);
    if (category) {
      category.append(createStrip(html));
    }
  };

  place();
  new MutationObserver(place).observe(editor, { childList: true, subtree: true });
}

/**
 * Places the strip below the headline of the constant category that contains the given constant, so it only
 * appears when the lightbox constants are shown.
 */
export function insertIntoConstantEditor(html, constantName) {
  const place = () => {
    const form = document.getElementById(CONSTANT_EDITOR_FORM_ID);
    if (!form || form.querySelector(STRIP_SELECTOR)) {
      return;
    }
    const constantLabel = [...form.querySelectorAll('.form-label code')]
      .find((code) => code.textContent.trim() === `[${constantName}]`);
    let heading = constantLabel?.closest('fieldset')?.previousElementSibling;
    while (heading && heading.tagName !== 'H2') {
      heading = heading.previousElementSibling;
    }
    heading?.after(createStrip(html));
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', place, { once: true });
  } else {
    place();
  }
}
