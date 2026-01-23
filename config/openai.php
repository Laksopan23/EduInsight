<?php

return [
    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
    'max_tokens' => env('OPENAI_MAX_TOKENS', 500),
    'temperature' => env('OPENAI_TEMPERATURE', 0.7),
]; 