# array_set

Set an item in an array using "dot" notation.

## Parameters

* array (`array`, `instruction`) - The array to get the value from.
* key (`string`, `instruction`) - The key to get the value for.
* value (`any`, `instruction`) - The value to set.

## Return

(`array`) - The array with the new value set.

## Exceptions

* `EvaluationException` - If there was an error while evaluating one or more parameters.
* `KeyException` - If the key is not found.
* `TypeException` - If one or more parameters are not of the expected type.

## Instruction Example

```json
{
  "type": "array_set",
  "_": {
    "array": {
      "foo": {
        "bar": "baz"
      }
    },
    "key": "foo.bar",
    "value": "qux"
  }
}
```

### Last Updated

Monday, December 26th, 2022.
Written by [Netkas](https://git.n64.cc/netkas)