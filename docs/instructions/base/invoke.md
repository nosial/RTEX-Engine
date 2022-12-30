# invoke

Invokes a method under a namespace.

## Parameters

* namespace (`string`) - The namespace to invoke the method under.
* method (`string`) - The method to invoke.
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
    "namespace": "system",
    "method": "print",
    "parameters": {
      "value": "Hello, world!"
    },
    "fail_on_error": true
  }
}
```

### Last Updated

Monday, December 29th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)