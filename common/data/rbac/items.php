<?php
return [
    'backend.*' => [
        'type' => 2,
    ],
    'rAdministrator' => [
        'type' => 1,
        'description' => 'Администратор системы',
        'children' => [
            'rNalInsp',
            'rUser',
            'rUnknownUser',
            'rResmiUnknownUser',
            'rMerchantBilling',
            'rMerchant',
            'rMerchantSmpp',
            'rMerchantBeelineDirectPayment',
            'rAgent',
            'rAgentSmpp',
            'rSubAgent',
            'rEmitent',
            'rEmitentMarketolog',
            'rEmitentOperational',
            'rEmitentPayWatcher',
            'rModerator',
            'rMarketolog',
            'rGuest',
            'rAuthorized',
            'rAll',
            'rOperatorSPP',
            'rJustRegistered',
            'rContentManager',
            'rTechSpecialist',
            'rMobileDeveloper',
            'rOperatorMT100',
            'rFinanceSpecialist',
            'rWPFinanceSpecialist',
            'rTextPagesManager',
            'rPromoter',
            'rCron',
            'rSubSubAgent',
            'rSubSubAgentsManager',
            'rPromoManager',
            'rEmployee',
            'rMerchantSmart',
            'rTester',
            'rPseudoUser',
            'rLoansRepaymentSpecialist',
            'rUserNotWorksheet',
            'rSecurityOfficer',
            'rAddresslessTransferUser',
            'rTransferUser',
            'rBPAdmin',
            'rBPSupportUser',
            'rResmiAdmin',
            'rResmiSPPAdmin',
            'rResmiSupportUser',
            'rAccountManager',
            'rPostExpressAdmin',
            'rPostExpressOperator',
            'rViewPostExpressReports',
            'rPartnerAuditor',
            'rSubagentAuditor',
            'rAgentOperator',
            'rMerchantOperator',
            'rSubAgentOperator',
            'rSubagentReports',
            'rBrokerAccount',
            'rSubAgentWithCashOut',
            'rSubMerchant',
            'backend.*',
            'geo.city.manage',
            'geo.country.manage',
            'geo.currency.manage',
            'service.category.manage',
            'service.service.manage',
            'user.profile.*',
        ],
    ],
    'rNalInsp' => [
        'type' => 1,
        'description' => 'Налоговый инспектор',
    ],
    'rUser' => [
        'type' => 1,
        'description' => 'Идентифицированный пользователь',
    ],
    'rUnknownUser' => [
        'type' => 1,
        'description' => 'Неидентифицированный пользователь',
    ],
    'rResmiUnknownUser' => [
        'type' => 1,
        'description' => 'Неидентифицированный пользователь resmi',
    ],
    'rMerchantBilling' => [
        'type' => 1,
        'description' => 'Мерчант с биллингом',
    ],
    'rMerchant' => [
        'type' => 1,
        'description' => 'Мерчант без биллинга',
    ],
    'rMerchantSmpp' => [
        'type' => 1,
        'description' => 'Мерчант',
    ],
    'rMerchantBeelineDirectPayment' => [
        'type' => 1,
        'description' => 'Мерчант',
    ],
    'rAgent' => [
        'type' => 1,
        'description' => 'Агент',
    ],
    'rAgentSmpp' => [
        'type' => 1,
        'description' => 'Агент',
    ],
    'rSubAgent' => [
        'type' => 1,
        'description' => 'Субагент',
    ],
    'rEmitent' => [
        'type' => 1,
        'description' => 'Эмитент-администратор',
    ],
    'rEmitentMarketolog' => [
        'type' => 1,
        'description' => 'Эмитент-маркетолог',
    ],
    'rEmitentOperational' => [
        'type' => 1,
        'description' => 'Эмитент-операционист',
    ],
    'rEmitentPayWatcher' => [
        'type' => 1,
        'description' => 'Роль, для просмотра платежей эмитента',
    ],
    'rModerator' => [
        'type' => 1,
        'description' => 'Модератор системы',
    ],
    'rMarketolog' => [
        'type' => 1,
        'description' => 'Маркетолог системы',
    ],
    'rGuest' => [
        'type' => 1,
        'description' => 'Гость системы',
    ],
    'rAuthorized' => [
        'type' => 1,
        'description' => 'Пользователь, вошедший в систему',
    ],
    'rAll' => [
        'type' => 1,
        'description' => 'Пользователь, вошедший в систему',
    ],
    'rOperatorSPP' => [
        'type' => 1,
        'description' => 'Оператор службы поддержки пользователей',
    ],
    'rJustRegistered' => [
        'type' => 1,
        'description' => 'Только что зарегистрированный пользователь',
    ],
    'rContentManager' => [
        'type' => 1,
        'description' => 'Контент менеджер',
    ],
    'rTechSpecialist' => [
        'type' => 1,
        'description' => 'Технический специалист',
    ],
    'rMobileDeveloper' => [
        'type' => 1,
        'description' => 'Разработчик мобильного приложения',
    ],
    'rOperatorMT100' => [
        'type' => 1,
        'description' => 'Оператор МТ100',
    ],
    'rFinanceSpecialist' => [
        'type' => 1,
        'description' => 'Специалист финансового отдела',
    ],
    'rWPFinanceSpecialist' => [
        'type' => 1,
        'description' => 'Специалист финансового отдела Wooppay',
    ],
    'rTextPagesManager' => [
        'type' => 1,
        'description' => 'Менеджер текстовых страниц',
    ],
    'rPromoter' => [
        'type' => 1,
        'description' => 'Промоутер',
    ],
    'rCron' => [
        'type' => 1,
        'description' => 'Имеет право рассылать отчеты мерчантам',
    ],
    'rSubSubAgent' => [
        'type' => 1,
        'description' => 'Суб-субагент',
    ],
    'rSubSubAgentsManager' => [
        'type' => 1,
        'description' => 'Создание cуб-субагента',
    ],
    'rPromoManager' => [
        'type' => 1,
        'description' => 'работа с промо-кодами',
    ],
    'rEmployee' => [
        'type' => 1,
        'description' => 'Сотрудник Wooppay',
    ],
    'rMerchantSmart' => [
        'type' => 1,
        'description' => 'Сматр школа',
    ],
    'rTester' => [
        'type' => 1,
        'children' => [
            'rest-client.*',
        ],
    ],
    'rPseudoUser' => [
        'type' => 1,
        'description' => 'временный юзер, создаваемый для пополнения с карты без регистрации',
    ],
    'rLoansRepaymentSpecialist' => [
        'type' => 1,
        'description' => 'Специалист по погашению кредитов',
    ],
    'rUserNotWorksheet' => [
        'type' => 1,
        'description' => 'Роль пользователя который не ввел анкетные данные',
    ],
    'rSecurityOfficer' => [
        'type' => 1,
        'description' => 'Сотрудник отдела ИБ',
    ],
    'rAddresslessTransferUser' => [
        'type' => 1,
        'description' => 'Пользователь, на которого проводится безадресный перевод',
    ],
    'rTransferUser' => [
        'type' => 1,
        'description' => 'Пользователь по умолчанию для операций по безадресным переводам',
    ],
    'rBPAdmin' => [
        'type' => 1,
        'description' => 'Администратор портала "Билайн"',
    ],
    'rBPSupportUser' => [
        'type' => 1,
        'description' => 'Сотрудник СПП портала "Билайн"',
    ],
    'rResmiAdmin' => [
        'type' => 1,
        'description' => 'Администратор портала "Salem"',
    ],
    'rResmiSPPAdmin' => [
        'type' => 1,
        'description' => 'Администратор службы поддержи пользователей Resmi',
    ],
    'rResmiSupportUser' => [
        'type' => 1,
        'description' => 'Сотрудник СПП портала "Salem"',
    ],
    'rAccountManager' => [
        'type' => 1,
        'description' => 'Аккаунт менеджер',
    ],
    'rPostExpressAdmin' => [
        'type' => 1,
        'description' => 'Администратор PostExpress',
    ],
    'rPostExpressOperator' => [
        'type' => 1,
        'description' => 'Оператор PostExpress',
    ],
    'rViewPostExpressReports' => [
        'type' => 1,
        'description' => 'Роль для просмотра отчетов пост экспресса',
    ],
    'rPartnerAuditor' => [
        'type' => 1,
        'description' => 'Партнёр с правом просмотра акта сверки',
    ],
    'rSubagentAuditor' => [
        'type' => 1,
        'description' => 'субагент с правом просматривать реестр по кошельку',
    ],
    'rAgentOperator' => [
        'type' => 1,
        'description' => 'оператор агента',
    ],
    'rMerchantOperator' => [
        'type' => 1,
        'description' => 'оператор мерчанта',
    ],
    'rSubAgentOperator' => [
        'type' => 1,
        'description' => 'оператор субагента',
    ],
    'rSubagentReports' => [
        'type' => 1,
        'description' => 'Субагент с правом доступа к своим отчетам в partnerCabinet',
    ],
    'rBrokerAccount' => [
        'type' => 1,
        'description' => 'Физик с правом пополняться с брокерского счёта',
    ],
    'rSubAgentWithCashOut' => [
        'type' => 1,
        'description' => 'Субагент с возможностью создания операций на вывод',
    ],
    'rSubMerchant' => [
        'type' => 1,
        'description' => 'Субмерчант',
    ],
    'geo.city.manage' => [
        'type' => 2,
    ],
    'geo.country.manage' => [
        'type' => 2,
    ],
    'geo.currency.manage' => [
        'type' => 2,
    ],
    'service.category.manage' => [
        'type' => 2,
    ],
    'service.service.manage' => [
        'type' => 2,
    ],
    'rest-client.*' => [
        'type' => 2,
    ],
    'user.profile.*' => [
        'type' => 2,
    ],
];
