<?php
//Регестрирую обрабутчики событий на создание и обновление пользователя
AddEventHandler("main", "OnAfterUserAdd", Array("EventHandlerResume", "OnAfterUserAddHandler"));
AddEventHandler("main", "OnAfterUserUpdate", Array("EventHandlerResume", "OnAfterUserUpdateHandler"));

//Класс для обработки событий
class EventHandlerResume {
    //Метод после изменения параметров пользователя
    public static function OnAfterUserUpdateHandler(&$arFields){
        self::AddingUserToGroupEvent($arFields);
    }
    //Метод после создания пользователя
    public static function OnAfterUserAddHandler(&$arFields) {
        self::AddingUserToGroupEvent($arFields);
    }
    //Метод обработки события добавления пользователя в группу контент-редакторы
    private static function AddingUserToGroupEvent(&$arFields) {
        if ($arFields["ID"] > 0) {
            // Получаем информацию о пользователе
            $rsUser = CUser::GetByID($arFields["ID"]);
            $arUser = $rsUser->Fetch();

            //ИД группы контент-редакторы
            $groupID = 5;

            // Получаем группы, к которым принадлежит пользователь
            $userGroups = CUser::GetUserGroup($arFields["ID"]);

            // Проверяем, входит ли нужная группа в массив групп пользователя
            $isInGroup = in_array($groupID, $userGroups);

            // Если пользователь в нужной группе, отправляем уведомление
            if ($isInGroup) {
                $eventName = "NEW_USER_IN_GROUP";
                $arEventFields = array(
                    "EMAIL_TO" => $arUser["EMAIL"],
                    "USER_NAME" => $arUser["NAME"],
                    "USER_EMAIL" => $arUser["EMAIL"],
                );

                // Пытаемся отправить сообщение
                CEvent::Send($eventName, "s1", $arEventFields);

            }
        }
    }
}