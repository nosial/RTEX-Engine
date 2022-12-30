# get

Gets an existing variable from the environment.

## Parameters

* name (`string`) - The name of the variable to get.

## Return

(`any`) - The value of the variable.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `TypeException` - If one or more parameters are not of the expected type.
* `NameException` - If the variable does not exist.


## Instruction Example

```json
{
  "type": "get",
  "_": {
    "name": "foo"
  }
}
```

### Last Updated

Monday, December 29th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)