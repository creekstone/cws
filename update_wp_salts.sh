#!/bin/bash

# Create a temporary file with the new salt definitions
cat > wp-salts.txt << 'EOL'
define('AUTH_KEY',         'X9/|+>`t({r}|lbi]z<FV@u`rRc5t:6G1+CxKcX+A(]7}Cw;ifLfYH^!8On*MOi0');
define('SECURE_AUTH_KEY',  '<Na4W_*&nbD +@K*e!?ulk]2OJ?<Oc=QpW%cMcFL(++riwUUhtJ:m5/4Xn<T1ZsU');
define('LOGGED_IN_KEY',    ':^|0 _UpA<Vzy`4OnGdju%9_yl*QQNB~yLG~qRU@9H1DM:@VG}CIxn8-cb(:o2h=');
define('NONCE_KEY',        '2=4Is /[$-<G-+<>k|d,C~XhMXYF N.>qC:o;~i`wU>*&cwm7JxVb9@_e>TvfkRo');
define('AUTH_SALT',        'tdONi(qwtXJI|I9pa~fitU0kY4-Ll&Nwtk{U-q9$@cO+Cw#|m26kyt}R-9}h m|X');
define('SECURE_AUTH_SALT', 'Y^+SIL3hhQatwNY{o BE.hpX9lj`#DWB?pUy+/uS?OH6dX&G,AT>AmG4`XA,H+q}');
define('LOGGED_IN_SALT',   'kD!8.}dA>xpSKK?udUS[ZNU..8#ntjnh:1-%RJYcG-WI2{t3+<z:$SbV{;orFU7x');
define('NONCE_SALT',       '2iK</oYV?5&EPO|($9?S|c@Qrc)P(=ZzM)-b<?3+>22Tq?/TQ#;Y9w,5%){A~llx');
EOL

# Upload the file to the server
scp -P 18765 wp-salts.txt u1627-cfgvmwjqr72b@gtxm1123.siteground.biz:/home/customer/www/creekstonecap.com/public_html/

# Update wp-config.php with the new salts using sed
ssh -p 18765 u1627-cfgvmwjqr72b@gtxm1123.siteground.biz "cd /home/customer/www/creekstonecap.com/public_html/ && \
  sed -i.bak -e '/AUTH_KEY/r wp-salts.txt' -e '/AUTH_KEY/,/NONCE_SALT/d' wp-config.php && \
  rm wp-salts.txt wp-config.php.bak"

# Clean up local temporary file
rm wp-salts.txt 
 