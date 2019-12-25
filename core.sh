#!/usr/bin/env bash
eval 'php artisan view:clear && php artisan cache:clear &&  php artisan config:cache'