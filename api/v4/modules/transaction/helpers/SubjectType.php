<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 03.08.2017
 * Time: 17:35
 */

namespace api\v4\modules\transaction\helpers;


class SubjectType {
	/**
	 * Контрагент может выполнять операции эмитента
	 */
	const EMITENT = 1000;
	
	/**
	 * Контрагент администрирует пользователей эмитента
	 */
	const EMITENT_ADMIN = 1001;
	
	/**
	 * Операционист эмитента, проводит операции
	 */
	const EMITENT_OPERATIONIST = 1002;
	
	/**
	 * Маркетолог эмитента, смотрит отчеты по операциям
	 */
	const EMITENT_MARKETOLOG = 1003;
	
	/**
	 * Контрагент может выполнять операции агента
	 */
	const AGENT = 2000;
	
	/**
	 * Контрагент может выполнять операции агента, пользуется своим счетом
	 */
	const SUB_AGENT = 2001;
	
	/**
	 * Субсубагент может выполнять операции агента, пользуется счетом субагента
	 */
	const SUB_SUB_AGENT = 2002;
	
	/**
	 * Контрагент может выполнять операции торговца
	 */
	const MERCHANT = 3000;
	
	/**
	 * Группа идентифицированных контрагентов, может выполнять операции идентифицированного пользователя
	 */
	const USER_IDENT = 4000;
	
	/**
	 * Группа неидентифицированных контрагентов, может выполнять операции неидентифицированного пользователя
	 */
	const USER_UNIDENT = 5000;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, Smart School
	 */
	const USER_UNIDENT_SMART = 5001;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, оплата без регистрации
	 */
	const USER_UNIDENT_PSEUDO = 5002;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, безадресный перевод
	 */
	const USER_UNIDENT_ADDRESSLESS = 5003;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, вывод на карту
	 */
	const USER_UNIDENT_WITHDRAWAL = 5004;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, автоматическое создание при покупке страхового полиса
	 */
	const USER_UNIDENT_POLICY = 5005;
	
	/**
	 * Пользователь, автоматически создаваемый при оплате через портал Beeline
	 */
	const USER_BEELINE_PORTAL_GENERATED = 5006;
	
	/**
	 *  СПП портала Beeline
	 */
	const USER_BEELINE_PORTAL_SUPPORT_USER = 5007;
	
	/**
	 *
	 */
	const USER_POST_EXPRESS_OPERATOR = 5008;
	
	/**
	 *
	 */
	const USER_POST_EXPRESS_ADMIN = 5009;
	
	/**
	 * Пользователь, автоматически создаваемый при оплате услуг мерчантом от имени пользователя
	 */
	const USER_UNIDENT_PSEUDO_BY_AGENT = 5010;
	
	/**
	 * Пользователь, автоматически создаваемый при входе через соц. сети
	 */
	const USER_UNIDENT_PSEUDO_SOCIAL = 5011;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, Resmi
	 */
	const USER_UNIDENT_RESMI = 5012;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, оплата без регистрации, Resmi
	 */
	const USER_UNIDENT_RESMI_PSEUDO = 5013;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, безадресный перевод, Resmi
	 */
	const USER_UNIDENT_RESMI_ADDRESSLESS = 5014;
	
	/**
	 * СПП Resmi
	 */
	const USER_RESMI_SUPPORT_USER = 5015;
	
	/**
	 * оператор мерчантской точки
	 */
	const USER_MERCHANT_POINT_OPERATOR = 5016;
	
	/**
	 *  СПП портала Kcell
	 */
	const USER_KCELL_PORTAL_SUPPORT_USER = 5017;
	
	/**
	 * Пользователь, автоматически создаваемый при оплате через портал Kcell
	 */
	const USER_KCELL_PORTAL_GENERATED = 5018;
	
	/**
	 * Контрагент может выполнять операции неидентифицированного пользователя, оплата без регистрации, с привязкой карт
	 */
	const USER_UNIDENT_PSEUDO_WITH_CARDS = 5019;
	
	/**
	 * Администратор системы
	 */
	const ADMIN = 6000;
	
	/**
	 * Модератор системы
	 */
	const MODERATOR = 6001;
	
	/**
	 * Маркетолог системы
	 */
	const MARKETOLOG = 6002;
	
	/**
	 * Маркетолог resmi
	 */
	const MARKETOLOG_RESMI = 6003;
	
	/**
	 * Налоговый инспектор системы
	 */
	const TAX_INSPECTOR = 7000;
	
	
	/**
	 * @inheritdoc
	 */
	public static function getKeys() {
		return array(
			"EMITENT",
			"EMITENT_ADMIN",
			"EMITENT_OPERATIONIST",
			"EMITENT_MARKETOLOG",
			"AGENT",
			"SUB_AGENT",
			"SUB_SUB_AGENT",
			"MERCHANT",
			"USER_IDENT",
			"USER_UNIDENT",
			"USER_UNIDENT_SMART",
			"USER_UNIDENT_PSEUDO",
			"USER_UNIDENT_ADDRESSLESS",
			"USER_UNIDENT_WITHDRAWAL",
			"USER_UNIDENT_POLICY",
			"USER_BEELINE_PORTAL_GENERATED",
			"USER_BEELINE_PORTAL_SUPPORT_USER",
			"USER_POST_EXPRESS_OPERATOR",
			"USER_POST_EXPRESS_ADMIN",
			"USER_UNIDENT_PSEUDO_BY_AGENT",
			"USER_UNIDENT_PSEUDO_SOCIAL",
			"USER_UNIDENT_RESMI",
			"USER_UNIDENT_RESMI_PSEUDO",
			"USER_UNIDENT_RESMI_ADDRESSLESS",
			"USER_RESMI_SUPPORT_USER",
			"USER_MERCHANT_POINT_OPERATOR",
			"USER_KCELL_PORTAL_SUPPORT_USER",
			"USER_KCELL_PORTAL_GENERATED",
			"USER_UNIDENT_PSEUDO_WITH_CARDS",
			"ADMIN",
			"MODERATOR",
			"MARKETOLOG",
			"MARKETOLOG_RESMI",
			"TAX_INSPECTOR",
		);
	}
}