cp  ./upload/admin/controller/extension/payment/stellar_net.php ./admin/controller/extension/payment/stellar_net.php

cp ./upload/admin/language_en-gb/extension/payment/stellar_net.php ./admin/language_en-gb/extension/payment/stellar_net.php

cp ./upload/admin/view/template/extension/payment/stellar_net.tpl ./admin/view/template/extension/payment/stellar_net.tpl

cp ./upload/catalog/controller/extension/payment/stellar_net.php ./catalog/controller/extension/payment/stellar_net.php

cp ./upload/catalog/language/en-gb_extension/payment/stellar_net.php ./catalog/language/en-gb_extension/payment/stellar_net.php

cp ./upload/catalog/model/extension/payment/stellar_net.php ./catalog/model/extension/payment/stellar_net.php

cp ./upload/catalog/view/theme/default/template/extension/payment/stellar_net.tpl ./catalog/view/theme/default/template/extension/payment/stellar_net.tpl

mkdir -p ./catalog/view/javascript/qrcode
cp ./upload/catalog/view/javascript/qrcode/qrcode.js ./catalog/view/javascript/qrcode/qrcode.js

mv ./catalog/controller/common/header.php ./catalog/controller/common/header.php.org
cp ./upload/catalog/controller/common/header.php ./catalog/controller/common/header.php
