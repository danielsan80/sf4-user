alias ll="ls -alFh"
alias memflush="echo \"flush_all\" | nc servicememcached 11211 -q 1"
alias xon="export XDEBUG_CONFIG=\"idekey=phpstorm-xdebug\"; export XDEBUG_CONFIG=\"remote_enable=1\""
alias xoff="export XDEBUG_CONFIG=\"\"; export XDEBUG_CONFIG=\"remote_enable=0\""
alias test="bin/phpunit -c app --exclude-group ignored"
alias test-ignored="bin/phpunit -c app --group ignored"
alias test-all="bin/phpunit -c app"
alias sf="bin/console"
alias sfcc="rm -Rf var/cache/*"