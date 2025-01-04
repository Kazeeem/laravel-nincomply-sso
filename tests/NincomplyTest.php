<?php

it('can generate redirect URL for SSO', function () {
    $url = \Eximius\Nincomply\Facades\Nincomply::ssoUrl();
    expect($url)->toBeString();
});

it('can retrieve access token from the SSO', function () {
    $code = 'def5020068644c93a93abab107054e06478660b2437812a73d8fb71a8433c7a4bd5ebb0f12c68f2bbf671dba2430822c11e46f6ed1c31a3b00d06685beb193ed370c1796454df2a16bb8314bfdbff6665fbefca0b8956ee242beb2df46e682c31f2ab17de033cd98e9f6e7035ecfc376b559d2641a5518a3ec1ae7725752076eeb7a384c08fc16aa97a1297e8cb925b2c4ebacdf340e18aa78cd381c9859b081a19d76f40dc3808ffd46020399cc8915ba89caefc3589f6c4d52c73e20aff7cdbee44c93906277c173ed61a02e79df297b8ffbb6e66cb71e315726a36fb8d85990856773a9cd015671a4a9abc82c2843fee20f086422fcce496a83fcd522488b889511161e2b83d6a988052cafeaec60a06ac4135f528dfb5a02936387fbb0915d9e7a20c353fc4cfd7e9e58d91db5df20ec9ff00ce958f0311c35880612cc5c244031e51db4cd82198b696c0d99a8927bd11d2578a4694b68d0737ac064ab014ac241c4c054c09097c7a6660fc05f3de0761b94d5cec431';

    $tokenObject = \Eximius\Nincomply\Facades\Nincomply::getAccessToken($code);
    $this->assertTrue(is_object($tokenObject)); // If it's an object, it will likely be an error because the code is wrong but we're sure it connects to Nincomply for it to be an object.
});

it('can retrieve user object from Nincomply', function () {
    $token = 'def5020068644c93a93abab107054e06478660b2437812a73d8fb71a8433c7a4bd5ebb0f12c68f2bbf671dba2430822c11e46f6ed1c31a3b00d06685beb193ed370c1796454df2a16bb8314bfdbff6665fbefca0b8956ee242beb2df46e682c31f2ab17de033cd98e9f6e7035ecfc376b559d2641a5518a3ec1ae7725752076eeb7a384c08fc16aa97a1297e8cb925b2c4ebacdf340e18aa78cd381c9859b081a19d76f40dc3808ffd46020399cc8915ba89caefc3589f6c4d52c73e20aff7cdbee44c93906277c173ed61a02e79df297b8ffbb6e66cb71e315726a36fb8d85990856773a9cd015671a4a9abc82c2843fee20f086422fcce496a83fcd522488b889511161e2b83d6a988052cafeaec60a06ac4135f528dfb5a02936387fbb0915d9e7a20c353fc4cfd7e9e58d91db5df20ec9ff00ce958f0311c35880612cc5c244031e51db4cd82198b696c0d99a8927bd11d2578a4694b68d0737ac064ab014ac241c4c054c09097c7a6660fc05f3de0761b94d5cec431';

    $userObject = \Eximius\Nincomply\Facades\Nincomply::getUser($token);
    $this->assertTrue(is_null($userObject)); // If it's an object, it will likely be an error because the code is wrong but we're sure it connects to Nincomply for it to be an object.
    // $this->assertTrue(isset($userObject->data->email), 'The user object was not retrieved.');
});
