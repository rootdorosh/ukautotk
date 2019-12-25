#!/usr/bin/env bash
php artisan migrate && 
php artisan db:seed --class=PermissionsTableSeeder &&
php artisan db:seed --class=ConnectRelationshipsSeeder &&
php artisan db:seed --class=EventsTableSeeder