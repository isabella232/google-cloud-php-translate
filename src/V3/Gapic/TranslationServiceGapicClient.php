<?php
/*
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/translate/v3/translation_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Translate\V3\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Translate\V3\BatchTranslateTextRequest;
use Google\Cloud\Translate\V3\CreateGlossaryRequest;
use Google\Cloud\Translate\V3\DeleteGlossaryRequest;
use Google\Cloud\Translate\V3\DetectLanguageRequest;
use Google\Cloud\Translate\V3\DetectLanguageResponse;
use Google\Cloud\Translate\V3\GetGlossaryRequest;
use Google\Cloud\Translate\V3\GetSupportedLanguagesRequest;
use Google\Cloud\Translate\V3\Glossary;
use Google\Cloud\Translate\V3\InputConfig;
use Google\Cloud\Translate\V3\ListGlossariesRequest;
use Google\Cloud\Translate\V3\ListGlossariesResponse;
use Google\Cloud\Translate\V3\OutputConfig;
use Google\Cloud\Translate\V3\SupportedLanguages;
use Google\Cloud\Translate\V3\TranslateTextGlossaryConfig;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use Google\Cloud\Translate\V3\TranslateTextResponse;
use Google\LongRunning\Operation;

/**
 * Service Description: Provides natural language translation operations.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $translationServiceClient = new TranslationServiceClient();
 * try {
 *     $formattedName = $translationServiceClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
 *     $operationResponse = $translationServiceClient->deleteGlossary($formattedName);
 *     $operationResponse->pollUntilComplete();
 *     if ($operationResponse->operationSucceeded()) {
 *         $result = $operationResponse->getResult();
 *         // doSomethingWith($result)
 *     } else {
 *         $error = $operationResponse->getError();
 *         // handleError($error)
 *     }
 *
 *
 *     // Alternatively:
 *
 *     // start the operation, keep the operation name, and resume later
 *     $operationResponse = $translationServiceClient->deleteGlossary($formattedName);
 *     $operationName = $operationResponse->getName();
 *     // ... do other work
 *     $newOperationResponse = $translationServiceClient->resumeOperation($operationName, 'deleteGlossary');
 *     while (!$newOperationResponse->isDone()) {
 *         // ... do other work
 *         $newOperationResponse->reload();
 *     }
 *     if ($newOperationResponse->operationSucceeded()) {
 *       $result = $newOperationResponse->getResult();
 *       // doSomethingWith($result)
 *     } else {
 *       $error = $newOperationResponse->getError();
 *       // handleError($error)
 *     }
 * } finally {
 *     $translationServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 *
 * @experimental
 */
class TranslationServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.translation.v3.TranslationService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'translate.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
        'https://www.googleapis.com/auth/cloud-translation',
    ];
    private static $glossaryNameTemplate;
    private static $locationNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/translation_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/translation_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/translation_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/translation_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getGlossaryNameTemplate()
    {
        if (null == self::$glossaryNameTemplate) {
            self::$glossaryNameTemplate = new PathTemplate('projects/{project}/locations/{location}/glossaries/{glossary}');
        }

        return self::$glossaryNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (null == self::$locationNameTemplate) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'glossary' => self::getGlossaryNameTemplate(),
                'location' => self::getLocationNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a glossary resource.
     *
     * @param string $project
     * @param string $location
     * @param string $glossary
     *
     * @return string The formatted glossary resource.
     * @experimental
     */
    public static function glossaryName($project, $location, $glossary)
    {
        return self::getGlossaryNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'glossary' => $glossary,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location resource.
     *
     * @param string $project
     * @param string $location
     *
     * @return string The formatted location resource.
     * @experimental
     */
    public static function locationName($project, $location)
    {
        return self::getLocationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - glossary: projects/{project}/locations/{location}/glossaries/{glossary}
     * - location: projects/{project}/locations/{location}.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @experimental
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'translate.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Deletes a glossary, or cancels glossary construction
     * if the glossary isn't created yet.
     * Returns NOT_FOUND, if the glossary doesn't exist.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedName = $translationServiceClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
     *     $operationResponse = $translationServiceClient->deleteGlossary($formattedName);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $translationServiceClient->deleteGlossary($formattedName);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $translationServiceClient->resumeOperation($operationName, 'deleteGlossary');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the glossary to delete.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteGlossary($name, array $optionalArgs = [])
    {
        $request = new DeleteGlossaryRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'DeleteGlossary',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Translates input text and returns translated text.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $contents = [];
     *     $targetLanguageCode = '';
     *     $formattedParent = $translationServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $translationServiceClient->translateText($contents, $targetLanguageCode, $formattedParent);
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string[] $contents           Required. The content of the input in string format.
     *                                     We recommend the total content be less than 30k codepoints.
     *                                     Use BatchTranslateText for larger text.
     * @param string   $targetLanguageCode Required. The BCP-47 language code to use for translation of the input
     *                                     text, set to one of the language codes listed in Language Support.
     * @param string   $parent             Required. Project or location to make a call. Must refer to a caller's
     *                                     project.
     *
     * Format: `projects/{project-number-or-id}` or
     * `projects/{project-number-or-id}/locations/{location-id}`.
     *
     * For global calls, use `projects/{project-number-or-id}/locations/global` or
     * `projects/{project-number-or-id}`.
     *
     * Non-global location is required for requests using AutoML models or
     * custom glossaries.
     *
     * Models and glossaries must be within the same region (have same
     * location-id), otherwise an INVALID_ARGUMENT (400) error is returned.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $mimeType
     *          Optional. The format of the source text, for example, "text/html",
     *           "text/plain". If left blank, the MIME type defaults to "text/html".
     *     @type string $sourceLanguageCode
     *          Optional. The BCP-47 language code of the input text if
     *          known, for example, "en-US" or "sr-Latn". Supported language codes are
     *          listed in Language Support. If the source language isn't specified, the API
     *          attempts to identify the source language automatically and returns the
     *          source language within the response.
     *     @type string $model
     *          Optional. The `model` type requested for this translation.
     *
     *          The format depends on model type:
     *
     *          - AutoML Translation models:
     *            `projects/{project-number-or-id}/locations/{location-id}/models/{model-id}`
     *
     *          - General (built-in) models:
     *            `projects/{project-number-or-id}/locations/{location-id}/models/general/nmt`,
     *            `projects/{project-number-or-id}/locations/{location-id}/models/general/base`
     *     @type TranslateTextGlossaryConfig $glossaryConfig
     *          Optional. Glossary to be applied. The glossary must be
     *          within the same region (have the same location-id) as the model, otherwise
     *          an INVALID_ARGUMENT (400) error is returned.
     *     @type array $labels
     *          Optional. The labels with user-defined metadata for the request.
     *
     *          Label keys and values can be no longer than 63 characters
     *          (Unicode codepoints), can only contain lowercase letters, numeric
     *          characters, underscores and dashes. International characters are allowed.
     *          Label values are optional. Label keys must start with a letter.
     *
     *          See https://cloud.google.com/translate/docs/labels for more information.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Translate\V3\TranslateTextResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function translateText($contents, $targetLanguageCode, $parent, array $optionalArgs = [])
    {
        $request = new TranslateTextRequest();
        $request->setContents($contents);
        $request->setTargetLanguageCode($targetLanguageCode);
        $request->setParent($parent);
        if (isset($optionalArgs['mimeType'])) {
            $request->setMimeType($optionalArgs['mimeType']);
        }
        if (isset($optionalArgs['sourceLanguageCode'])) {
            $request->setSourceLanguageCode($optionalArgs['sourceLanguageCode']);
        }
        if (isset($optionalArgs['model'])) {
            $request->setModel($optionalArgs['model']);
        }
        if (isset($optionalArgs['glossaryConfig'])) {
            $request->setGlossaryConfig($optionalArgs['glossaryConfig']);
        }
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'TranslateText',
            TranslateTextResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Detects the language of text within a request.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedParent = $translationServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $translationServiceClient->detectLanguage($formattedParent);
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. Project or location to make a call. Must refer to a caller's
     *                       project.
     *
     * Format: `projects/{project-number-or-id}/locations/{location-id}` or
     * `projects/{project-number-or-id}`.
     *
     * For global calls, use `projects/{project-number-or-id}/locations/global` or
     * `projects/{project-number-or-id}`.
     *
     * Only models within the same region (has same location-id) can be used.
     * Otherwise an INVALID_ARGUMENT (400) error is returned.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $model
     *          Optional. The language detection model to be used.
     *
     *          Format:
     *          `projects/{project-number-or-id}/locations/{location-id}/models/language-detection/{model-id}`
     *
     *          Only one language detection model is currently supported:
     *          `projects/{project-number-or-id}/locations/{location-id}/models/language-detection/default`.
     *
     *          If not specified, the default model is used.
     *     @type string $content
     *          The content of the input stored as a string.
     *     @type string $mimeType
     *          Optional. The format of the source text, for example, "text/html",
     *          "text/plain". If left blank, the MIME type defaults to "text/html".
     *     @type array $labels
     *          Optional. The labels with user-defined metadata for the request.
     *
     *          Label keys and values can be no longer than 63 characters
     *          (Unicode codepoints), can only contain lowercase letters, numeric
     *          characters, underscores and dashes. International characters are allowed.
     *          Label values are optional. Label keys must start with a letter.
     *
     *          See https://cloud.google.com/translate/docs/labels for more information.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Translate\V3\DetectLanguageResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function detectLanguage($parent, array $optionalArgs = [])
    {
        $request = new DetectLanguageRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['model'])) {
            $request->setModel($optionalArgs['model']);
        }
        if (isset($optionalArgs['content'])) {
            $request->setContent($optionalArgs['content']);
        }
        if (isset($optionalArgs['mimeType'])) {
            $request->setMimeType($optionalArgs['mimeType']);
        }
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DetectLanguage',
            DetectLanguageResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns a list of supported languages for translation.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedParent = $translationServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $response = $translationServiceClient->getSupportedLanguages($formattedParent);
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. Project or location to make a call. Must refer to a caller's
     *                       project.
     *
     * Format: `projects/{project-number-or-id}` or
     * `projects/{project-number-or-id}/locations/{location-id}`.
     *
     * For global calls, use `projects/{project-number-or-id}/locations/global` or
     * `projects/{project-number-or-id}`.
     *
     * Non-global location is required for AutoML models.
     *
     * Only models within the same region (have same location-id) can be used,
     * otherwise an INVALID_ARGUMENT (400) error is returned.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $displayLanguageCode
     *          Optional. The language to use to return localized, human readable names
     *          of supported languages. If missing, then display names are not returned
     *          in a response.
     *     @type string $model
     *          Optional. Get supported languages of this model.
     *
     *          The format depends on model type:
     *
     *          - AutoML Translation models:
     *            `projects/{project-number-or-id}/locations/{location-id}/models/{model-id}`
     *
     *          - General (built-in) models:
     *            `projects/{project-number-or-id}/locations/{location-id}/models/general/nmt`,
     *            `projects/{project-number-or-id}/locations/{location-id}/models/general/base`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Translate\V3\SupportedLanguages
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSupportedLanguages($parent, array $optionalArgs = [])
    {
        $request = new GetSupportedLanguagesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['displayLanguageCode'])) {
            $request->setDisplayLanguageCode($optionalArgs['displayLanguageCode']);
        }
        if (isset($optionalArgs['model'])) {
            $request->setModel($optionalArgs['model']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetSupportedLanguages',
            SupportedLanguages::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Translates a large volume of text in asynchronous batch mode.
     * This function provides real-time output as the inputs are being processed.
     * If caller cancels a request, the partial results (for an input file, it's
     * all or nothing) may still be available on the specified output location.
     *
     * This call returns immediately and you can
     * use google.longrunning.Operation.name to poll the status of the call.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedParent = $translationServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $sourceLanguageCode = '';
     *     $targetLanguageCodes = [];
     *     $inputConfigs = [];
     *     $outputConfig = new OutputConfig();
     *     $operationResponse = $translationServiceClient->batchTranslateText($formattedParent, $sourceLanguageCode, $targetLanguageCodes, $inputConfigs, $outputConfig);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $translationServiceClient->batchTranslateText($formattedParent, $sourceLanguageCode, $targetLanguageCodes, $inputConfigs, $outputConfig);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $translationServiceClient->resumeOperation($operationName, 'batchTranslateText');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. Location to make a call. Must refer to a caller's project.
     *
     * Format: `projects/{project-number-or-id}/locations/{location-id}`.
     *
     * The `global` location is not supported for batch translation.
     *
     * Only AutoML Translation models or glossaries within the same region (have
     * the same location-id) can be used, otherwise an INVALID_ARGUMENT (400)
     * error is returned.
     * @param string        $sourceLanguageCode  Required. Source language code.
     * @param string[]      $targetLanguageCodes Required. Specify up to 10 language codes here.
     * @param InputConfig[] $inputConfigs        Required. Input configurations.
     *                                           The total number of files matched should be <= 1000.
     *                                           The total content size should be <= 100M Unicode codepoints.
     *                                           The files must use UTF-8 encoding.
     * @param OutputConfig  $outputConfig        Required. Output configuration.
     *                                           If 2 input configs match to the same file (that is, same input path),
     *                                           we don't generate output for duplicate inputs.
     * @param array         $optionalArgs        {
     *                                           Optional.
     *
     *     @type array $models
     *          Optional. The models to use for translation. Map's key is target language
     *          code. Map's value is model name. Value can be a built-in general model,
     *          or an AutoML Translation model.
     *
     *          The value format depends on model type:
     *
     *          - AutoML Translation models:
     *            `projects/{project-number-or-id}/locations/{location-id}/models/{model-id}`
     *
     *          - General (built-in) models:
     *            `projects/{project-number-or-id}/locations/{location-id}/models/general/nmt`,
     *            `projects/{project-number-or-id}/locations/{location-id}/models/general/base`
     *     @type array $glossaries
     *          Optional. Glossaries to be applied for translation.
     *          It's keyed by target language code.
     *     @type array $labels
     *          Optional. The labels with user-defined metadata for the request.
     *
     *          Label keys and values can be no longer than 63 characters
     *          (Unicode codepoints), can only contain lowercase letters, numeric
     *          characters, underscores and dashes. International characters are allowed.
     *          Label values are optional. Label keys must start with a letter.
     *
     *          See https://cloud.google.com/translate/docs/labels for more information.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchTranslateText($parent, $sourceLanguageCode, $targetLanguageCodes, $inputConfigs, $outputConfig, array $optionalArgs = [])
    {
        $request = new BatchTranslateTextRequest();
        $request->setParent($parent);
        $request->setSourceLanguageCode($sourceLanguageCode);
        $request->setTargetLanguageCodes($targetLanguageCodes);
        $request->setInputConfigs($inputConfigs);
        $request->setOutputConfig($outputConfig);
        if (isset($optionalArgs['models'])) {
            $request->setModels($optionalArgs['models']);
        }
        if (isset($optionalArgs['glossaries'])) {
            $request->setGlossaries($optionalArgs['glossaries']);
        }
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchTranslateText',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Creates a glossary and returns the long-running operation. Returns
     * NOT_FOUND, if the project doesn't exist.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedParent = $translationServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $glossary = new Glossary();
     *     $operationResponse = $translationServiceClient->createGlossary($formattedParent, $glossary);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $translationServiceClient->createGlossary($formattedParent, $glossary);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $translationServiceClient->resumeOperation($operationName, 'createGlossary');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The project name.
     * @param Glossary $glossary     Required. The glossary to create.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createGlossary($parent, $glossary, array $optionalArgs = [])
    {
        $request = new CreateGlossaryRequest();
        $request->setParent($parent);
        $request->setGlossary($glossary);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateGlossary',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Lists glossaries in a project. Returns NOT_FOUND, if the project doesn't
     * exist.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedParent = $translationServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $translationServiceClient->listGlossaries($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $translationServiceClient->listGlossaries($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the project from which to list all of the glossaries.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $filter
     *          Optional. Filter specifying constraints of a list operation.
     *          Filtering is not supported yet, and the parameter currently has no effect.
     *          If missing, no filtering is performed.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listGlossaries($parent, array $optionalArgs = [])
    {
        $request = new ListGlossariesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListGlossaries',
            $optionalArgs,
            ListGlossariesResponse::class,
            $request
        );
    }

    /**
     * Gets a glossary. Returns NOT_FOUND, if the glossary doesn't
     * exist.
     *
     * Sample code:
     * ```
     * $translationServiceClient = new TranslationServiceClient();
     * try {
     *     $formattedName = $translationServiceClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
     *     $response = $translationServiceClient->getGlossary($formattedName);
     * } finally {
     *     $translationServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the glossary to retrieve.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Translate\V3\Glossary
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getGlossary($name, array $optionalArgs = [])
    {
        $request = new GetGlossaryRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetGlossary',
            Glossary::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
