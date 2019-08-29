<?php

// handler template theme asset
# online version
function online_asset()
{
    return 'https://bachtiarswebsitecoltd.net/AdminLTE-2.4.17';
}
#offline version
function offline_asset()
{
    return asset('adminlte');
}
