<?php
/**
 * Класс для работы с API
 *
 * @author		Antipov Dmitry
 * @version		v.1.0 (07/04/2025)
 */
class Api
{
    public function __construct(
        private readonly string $paramLimiter = '%',
    )
    {

    }

    /**
     * Заполняет строковый шаблон template данными из объекта object
     *
     * @author		Antipov Dmitry
     * @version		v.1.0 (07/04/2025)
     * @param		array $array
     * @param		string $template
     * @return		string
     */
    public function get_api_path(array $array, string $template,) : string
    {
        /**
         * ПО результатам замера str_replace для классического пути выполняется быстрее других вариантов.
         */
        foreach ($array as $paramKey => $paramValue) {
            $template = str_replace($this->paramLimiter . $paramKey . $this->paramLimiter, $paramValue, $template);
        }

        return $template;
    }
}

$user = [
        'id'		=> 20,
        'name'		=> 'John Dow',
        'role'		=> 'QA',
        'salary'	=> 100,
    ];

$api_path_templates = [
        "/api/items/%id%/%name%",
        "/api/items/%id%/%role%",
        "/api/items/%id%/%salary%",
    ];

$api = new Api();

$api_paths = array_map(
    function ($api_path_template) use ($api, $user)
    {
        return $api->get_api_path($user, $api_path_template);
    },
    $api_path_templates
);

echo json_encode($api_paths, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

$expected_result = [
        '/api/items/20/John%20Dow',
        '/api/items/20/QA',
        '/api/items/20/100',
    ];
