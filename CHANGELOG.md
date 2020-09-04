## [1.1.2] - 2020-09-04
### Patch
- Change annotation property type of `DtoResolverTrait::definedProperties` and annotation return type `DtoResolverTrait::getDefinedProperties()`.

## [1.1.1] - 2019-06-25
### Fixed
- Fixed properties selection with not empty option resolver in `DtoResolverTrait`.

## [1.1.0] - 2019-06-17
### Added
- Added trait `DtoArrayAccessTrait` for implement ArrayAccess interface
- Added to interface `DtoResolverInterface` function `getDefinedProperties`.
### Changed
- Changed `DtoResolverTrait` added implementation `DtoResolverInterface`.
- Changed `CollectionDtoResolverInterface` optimization code.

## [1.0.0] - 2019-04-29
### Added
- Added possibility to build collection by specific collection item field.
### Changed
- Added `CollectionDtoResolverTrait::__construct()` with optional `OptionsResolver`.
- Added `DtoResolverTrait::__construct()` with required `array $data` and optional `OptionsResolver`.
- Added static method `CollectionDtoResolverInterface::getItemDtoClassName`.
### Removed
- Removed `CollectionDtoResolverInterface::injectResolver`.
- Removed `CollectionDtoResolverInterface::getEntryDtoClassName`.
- Removed `DtoResolverInterface::injectResolver` and `DtoResolverInterface::resolve`.
- Removed `DtoResolverFactory`.

## [0.4.0] - 2019-04-11
### Added
- Added `jsonSerialize` method in `CollectionDtoResolverTrait`.
- `CollectionDtoResolverInterface` implements `JsonSerializable` now.
### Removed
- Removed `createDto` method in `DtoResolverFactory`.

## [0.3.1] - 2019-04-04
### Added
- Added `.phpstorm.meta.php`.
- Added `DtoResolverFactory::create()`.

## [0.3.0] - 2019-04-04
### Added
- Added `injectResolver` method into `CollectionDtoResolverTrait`.
- Added `getOptionResolver` method into `CollectionDtoResolverTrait`.
- Added property existence check for `resolve` method in `DtoResolverTrait`.
### Changed
- Transform `AbstractDtoResolver` class into `DtoResolverTrait`.
- Transform `AbstractCollectionDtoResolver` class into `CollectionDtoResolverTrait`.
- Transfer `setDefined` method from `configureOptions` to `injectResolver` in `DtoResolverTrait`
- Fixed annotations into `CollectionDtoResolverInterface`, `CollectionDtoResolverTrait`, 
`DtoResolverInterface`, `DtoResolverTrait`.

## [0.2.1] - 2018-11-12
### Added
- Added `Iterator` implementation for the `AbstractCollectionDtoResolver`.

## [0.2.0] - 2018-09-26 [BC]
### Added
- Added `DtoResolverFactory`.
### Changed
- Process property name normalization before resolving.
### Fixed
- Improved stability against recursion.

## [0.1.1] - 2018-09-19
### Fixed
- Fixed circular reference in the default realisation of the `configureOptions` method.

## [0.1.0] - 2018-08-29
### Added
- First release of this component.
