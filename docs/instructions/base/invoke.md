# invoke

Invokes a method under a namespace.

## Parameters

* callable (`string`) - The callable to invoke. (e.g. `namespace.method`, `system.print`, `time.now`)
* parameters (`array`) - The parameters to pass to the method.
* fail_on_error (`boolean`) - Whether to fail if the method throws an exception.

## Return

(`any`) - The return value of the method. See the method's documentation for more information.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.
* `UndefinedMethodException` - If the method is not defined.
* `Exception` - If the method throws an exception and `fail_on_error` is `true`.

## Instruction Example

```json
{
  "type": "invoke",
  "_": {
    "callable": "system.print",
    "parameters": {
      "value": "Hello, world!"
    },
    "fail_on_error": true
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)