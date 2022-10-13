<?php

return [

    "include" => (bool)env("DEBUG_MODE", true),
    "debugDir" => env("DEBUG_PATH", 'app/DebugModels/'),

];
