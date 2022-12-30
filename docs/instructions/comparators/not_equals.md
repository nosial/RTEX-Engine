# neq

Returns true if the first argument is not equal to the second argument.

## Parameters

* a (`integer`, `float`, `double`, `string`, `boolean`) - The first value to compare.
* b (`integer`, `float`, `double`, `string`, `boolean`) - The second value to compare.

## Return

(`boolean`) - True if the first argument is not equal to the second argument.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.


## Instruction Example

```json
{
  "type": "neq",
  "_": {
    "a": "foo",
    "b": "foo"
  }
}
```

### Last Updated

Monday, December 30th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)