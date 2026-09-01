# IMET Offline Tool

<p align="center"><img alt="logo" src="/public/icon.png" style="width: 200px;"></p>

The **IMET Offline Tool** is a desktop application that allows users to conduct
[IMET](https://github.com/imettool/) (Integrated Management Effectiveness) assessments on protected areas and OECMs
(Other Effective area-based Conservation Measures) without any internet connection or server infrastructure.

It is built with [NativePHP](https://nativephp.com), packaging Laravel + Electron into a self-contained desktop app.

> [!IMPORTANT]
> This repository contains exclusively the code that turns IMET into a standalone desktop application.
> The actual code that creates and manages IMET / OECM assessments lives in the
> [imet-core](https://github.com/imettool/imet-core) package, which is loaded as a Composer dependency.

> [!NOTE]
> Currently distributed for **Windows 11 (x64)** only. Other platforms may be supported in the future.

## Getting started
A complete and comprehensive documentation of the codebase is available [here](docs/documentation.md).

## Issues
Please raise any issues on the [imettool/imet-core](https://github.com/imettool/imet-core/issues) repository.

## Copyright
Copyright (C) 2026 European Union

## License
This package is licensed under the [GPL-3.0 license](/LICENSE).
