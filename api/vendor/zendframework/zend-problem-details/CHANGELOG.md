# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

Versions 0.3.0 and prior were released as "weierophinney/problem-details".

## 0.5.0 - 2017-10-09

### Added

- In [#1](https://github.com/zendframework/zend-problem-details/pull/1),
  `Zend\ProblemDetails\ProblemDetailsResponseFactory` was updated to attempt to
  generate a secure-by-default and secure-in-production Problem Details response
  when the response is generated from an exception; essentially, it now defaults
  to NOT exposing this information, in order to prevent exposing internals of
  the application in production.

  To provide this, it adds two new, optional, constructor arguments:

  - `bool $exceptionDetailsInResponse` is a flag detailing whether or not
    details from an exception (except `ProblemDetailsException` custom data)
    should be used in the Problem Details response; by default this is `false`
  - `string $defaultDetailMessage` is a default message to use for the `detail`
    key of the response in such situations; the default value is `An unknown
    error occurred.`.

  Additionally, `ProblemDetailsResponseFactoryFactory` was updated to re-use the
  configuration `debug` setting for the `$exceptionDetailsInResponse` flag.

- [#7](https://github.com/zendframework/zend-problem-details/pull/7) adds a
  `ProblemDetailsNotFoundHandler` class and associated factory. This can be used
  in place of the default application `NotFoundHandler`, in addition to it, or
  within specific routed pipelines in order to provide Problem Details 404
  responses.

- [#8](https://github.com/zendframework/zend-problem-details/pull/8) adds
  `Zend\Expressive\ProblemDetails\Exception\ExceptionInterface`, a marker
  interface for exceptions provided by the package.

- [#12](https://github.com/zendframework/zend-problem-details/pull/12) adds
  support for http-interop/http-middleware 0.5.0 via a polyfill provided by the
  package webimpress/http-middleware-compatibility. Essentially, this means you
  can drop this package into an application targeting either the 0.4.1 or 0.5.0
  versions of http-middleware, and it will "just work".

### Changed

- [#8](https://github.com/zendframework/zend-problem-details/pull/8) renames the
  interface `ProblemDetailsException` to `ProblemDetailsExceptionInterface`.
  This was done to make the naming consistent with other ZF packages.

- [#8](https://github.com/zendframework/zend-problem-details/pull/8) renames the
  trait `CommonProblemDetailsException` to `CommonProblemDetailsExceptionTrait`.
  This was done to make the naming consistent with other ZF packages.

- [#8](https://github.com/zendframework/zend-problem-details/pull/8) updates the
  shipped `InvalidResponseBodyException` and `MissingResponseException` to
  extend the new `ExceptionInterface`.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.4.0 - 2017-08-01

### Added

- Nothing.

### Changed

- The package is now named "zendframework/zend-problem-details".
- The top-level namespace is now named `Zend\ProblemDetails`.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.0 - 2017-07-31

### Added

- [#7](https://github.com/weierophinney/problem-details/pull/7) adds an explicit
  dependency on ext/json.

### Changed

- [#7](https://github.com/weierophinney/problem-details/pull/7) updates each
  of the following to place them under the new `ProblemDetails\Exception`
  namespace:
  - `CommonProblemDetailsException`
  - `InvalidResponseBodyException`
  - `MissingResponseException`
  - `ProblemDetailsException`

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.2.1 - 2017-06-13

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#5](https://github.com/weierophinney/problem-details/pull/5) updates the
  response factory and middleware to treat lack of/empty `Accept` header values
  as `*/*`, per RFC-7231 section 5.3.2.

## 0.2.0 - 2017-05-30

### Added

- [#4](https://github.com/weierophinney/problem-details/pull/4) adds
  `ProblemDetailsReponseFactoryFactory` for generating a
  `ProblemDetailsResponseFactory` instance.

### Changed

- [#4](https://github.com/weierophinney/problem-details/pull/4) changes the
  `ProblemDetailsResponseFactory` in several ways:
  - It is now instantiable. The constructor accepts a boolean indicating debug
    status (`false` by default), an integer bitmask of JSON encoding flags, a
    PSR-7 `ResponseInterface` instance, and a callable factory for generating a
    writable PSR-7 `StreamInterface` for the final problem details response
    content.
  - `createResponse()` is now an instance method, and its first argument is no
    longer an `Accept` header, but a PSR-7 `ServerRequestInterface` instance.
  - `createResponseFromThrowable()` is now an instance method, and its first
    argument is no longer an `Accept` header, but a PSR-7
    `ServerRequestInterface` instance.

- [#4](https://github.com/weierophinney/problem-details/pull/4) changes the
  `ProblemDetailsMiddleware`; it now composes a `ProblemDetailsResponseFactory`
  insteead of an `isDebug` flag. Additionally, it no longer wraps processing of
  the delegate in a try/catch block if the request cannot accept JSON or XML.

- [#4](https://github.com/weierophinney/problem-details/pull/4) changes the
  `ProblemDetailsMiddlewareFactory` to inject the `ProblemDetailsMiddleware`
  with a `ProblemDetailsResponseFactory` instead of an `isDebug` flag.

### Deprecated

- Nothing.

### Removed

- [#4](https://github.com/weierophinney/problem-details/pull/4) removes the
  `ProblemDetailsJsonResponse`; use the `ProblemDetailsResponseFactory` instead.

- [#4](https://github.com/weierophinney/problem-details/pull/4) removes the
  `ProblemDetailsXmlResponse`; use the `ProblemDetailsResponseFactory` instead.

- [#4](https://github.com/weierophinney/problem-details/pull/4) removes the
  `CommonProblemDetails` trait; the logic is now incorporated in the
  `ProblemDetailsResponseFactory`.

- [#4](https://github.com/weierophinney/problem-details/pull/4) removes the
  `ProblemDetailsResponse` interface; PSR-7 response prototypes are now used
  instead.

### Fixed

- [#4](https://github.com/weierophinney/problem-details/pull/4) updates JSON
  response generation to allow specifying your own JSON encoding flags. By
  default, it now does pretty JSON, with unescaped slashes and unicode.

## 0.1.0 - 2017-05-03

Initial Release.

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
