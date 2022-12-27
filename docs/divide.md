# divide

Divide two numbers.

## Parameters

* a (`integer`, `float`, `double`, `instruction`) - The number to divide.
* b (`integer`, `float`, `double`, `instruction`) - The number to divide by.

## Return

(`integer`, `float`, `double`) - The result of the division.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.
* `ZeroDivisionException` - If the divisor is zero.

## Instruction Example

```json
{
  "type": "divide",
  "_": {
    "a": 10,
    "b": 2
  }
}
```

### Last Updated

Monday, December 26th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)