This extension allows you to deny specific payment methods for single customers.

Installation
------------

0. Backup your database.
1. Disable Compiler, if it is enabled.
2. Install this extension
   You could simply copy all these files into your Magento root folder.
   The better way is to use modman instead.
3. Clear Cache.
4. Open your shop backend. You will see a multiselect field of payment methods in your customer view.
5. You may now re-enable Compiler.


Uninstall
---------

Caution: Your shop won't work after removing this extension, because Magento offers no support for removal.
You need to run the following query before removing this extension:

    DELETE FROM eav_attribute WHERE attribute_code="denied_payment_methods"
