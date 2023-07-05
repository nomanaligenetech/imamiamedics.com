<?php
$config['payeezy_sandbox'] = false;

$config['payeezy_api'] = $config['payeezy_sandbox'] ? 'fAA5tikJAFNO1nU2AblN7NTDdgLMDkcj' : 'lA7G0w7GlswH82hqcoevffI1myMEY5I4';
$config['payeezy_secret'] = $config['payeezy_sandbox'] ? '087d023b8a9a6c1e75dff87c33350cfd2a551e2f1a4a6d5dc29f65c933a025c1' : '20a34c4a5d2176988f28e1674023448611995434e13d9c740f77cbbe9c20f043';
$config['payeezy_token'] = $config['payeezy_sandbox'] ? 'fdoa-d379a29ec898c4613225b5da85d5ae571083327fc7d5e570' : 'fdoa-80d67023b3b04c16c2fd808aa20e57bf76ead52ff4dab33d'; //Acme sock
//$config['payeezy_token'] = $config['payeezy_sandbox'] ? 'fdoa-e0d34fdc921f3b543b946ec7341ab034e654790ef7252370' : 'fdoa-80d67023b3b04c16c2fd808aa20e57bf76ead52ff4dab33d'; //Demo merchant ecomm
$config['payeezy_token'] = $config['payeezy_sandbox'] ? 'fdoa-6249c26e04b0e383915d6df2860e348fb5f71cbcea20f20b' : 'fdoa-80d67023b3b04c16c2fd808aa20e57bf76ead52ff4dab33d'; //Demo merchant retail
$config['payeezy_url'] = $config['payeezy_sandbox'] ? 'https://api-cert.payeezy.com/v1/' : 'https://api.payeezy.com/v1/';
$config['ta_token'] = $config['payeezy_sandbox'] ? 'NOIW' : 'NOIW'; //NOIW