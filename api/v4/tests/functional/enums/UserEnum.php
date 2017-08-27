<?php

namespace api\v4\tests\functional\enums;

class UserEnum
{
 
	const EXISTED_LOGIN = '77751112233';
	const EXISTED_TEMP_LOGIN = '77026665544';
	const EXISTED_TPS_LOGIN = '77751112233';
	const ADMIN_LOGIN = '77771111111';
	const FORMATTED_LOGIN = '+7 (775) (111)-(22)-(33)';
	const NOT_EXISTED_LOGIN = '77968422500';
	const NOT_EXISTED_BEELINE_LOGIN = 'B77021112233';
	const SMALL_LOGIN = '7796842258';
	const BIG_LOGIN = '779684225866';

	const PASSWORD = 'Wwwqqq111';
	const SMALL_PASSWORD = '111';
	const BAD_PASSWORD = 'Wwwqqq222';
	const CHANGED_PASSWORD = 'Wwwqqq222';

	const ACTIVATION_CODE = '123456';
	const BAD_ACTIVATION_CODE = '111111';
	const SMALL_ACTIVATION_CODE = '12345';

	const EMAIL = 'example@ya.ru';
	const NOT_VALID_EMAIL = 'exampleya.ru';
	const CHANGED_EMAIL = 'example222@ya.ru';
	
}
