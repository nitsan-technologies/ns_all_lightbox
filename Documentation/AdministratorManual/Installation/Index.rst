.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _installation:

Installation
============
The extension needs to be installed as any other extension of TYPO3 CMS:

Install Extension from EM:
--------------------------

#. Switch to the module “Extension Manager”.

#. Get the extension

#. **Get it from the Extension Manager:** Press the “Retrieve/Update” button and search for the extension key *ns_all_lightbox* and import the extension from the repository.

#. **Get it from typo3.org:** You can always get current version from `http://typo3.org/extensions/repository/view/ns_all_lightbox/current/ <http://typo3.org/extensions/repository/view/ns_all_lightbox/current/>`_ by downloading either the t3x or zip version. Upload the file afterwards in the Extension Manager.

|img-2|


Preparation: Include static TypoScript
--------------------------------------

The extension ships some TypoScript code which needs to be included.

#. Switch to the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Click the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Content Elements (fluid_styled_content)** at the field *Include static (from extensions):*

#. Select **[NITSAN] All In One Lightbox/Modalbox (ns_all_lightbox)** at the field *Include static (from extensions):*

#. **IMPORTANT**: About ordering, Please include this at the end of others.

|img-3|