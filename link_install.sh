ln -srf  ./upload/admin/controller/extension/payment/stellar_net.php ./admin/controller/extension/payment/stellar_net.php

ln -srf ./upload/admin/language/en-gb/extension/payment/stellar_net.php ./admin/language/en-gb/extension/payment/stellar_net.php


ln -srf ./upload/admin/view/template/extension/payment/stellar_net.tpl ./admin/view/template/extension/payment/stellar_net.tpl

ln -srf ./upload/catalog/controller/extension/payment/stellar_net.php ./catalog/controller/extension/payment/stellar_net.php

ln -srf ./upload/catalog/language/en-gb/extension/payment/stellar_net.php ./catalog/language/en-gb/extension/payment/stellar_net.php

ln -srf ./upload/catalog/model/extension/payment/stellar_net.php ./catalog/model/extension/payment/stellar_net.php

ln -srf ./upload/catalog/view/theme/default/template/extension/payment/stellar_net.tpl ./catalog/view/theme/default/template/extension/payment/stellar_net.tpl

mkdir -p ./catalog/view/javascript
ln -srf ./upload/catalog/view/javascript/qrcode ./catalog/view/javascript/qrcode

mv ./catalog/controller/common/header.php ./catalog/controller/common/header.php.org
ln -srf ./upload/catalog/controller/common/header.php ./catalog/controller/common/header.php

