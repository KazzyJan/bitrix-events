<?
//define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;

if ($USER->IsAuthorized()){
    $currentUser = CUser::GetByID($USER->GetID())->Fetch();

    echo "Имя: " . $currentUser["NAME"] . "<br>";
    echo "Фамилия: " . $currentUser["LAST_NAME"] . "<br>";
    echo "Email: " . $currentUser["EMAIL"] . "<br>";

    print_r($currentUser);
}
if (is_string($_REQUEST["backurl"]) && mb_strpos($_REQUEST["backurl"], "/") === 0)
{
	LocalRedirect($_REQUEST["backurl"]);
}

$APPLICATION->SetTitle("Вход на сайт");
?><p>
	Вы зарегистрированы и успешно авторизовались.
</p>
 <br>
 <?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	".default",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"FORGOT_PASSWORD_URL" => "",
		"PROFILE_URL" => "",
		"REGISTER_URL" => "/login/registration.php",
		"SHOW_ERRORS" => "N"
	)
);?><br>
<p>
 <a href="<?=SITE_DIR?>">Вернуться на главную страницу</a>
</p>
<p>
 <a href="/login/registration.php">Страница регистрации</a>
</p>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>