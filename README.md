# xhgui-docker

[![Release version](https://img.shields.io/github/release/cv21/xhgui-docker.svg)](https://github.com/cv21/xhgui/) [![Docker pulls](https://img.shields.io/docker/pulls/cv21/xhgui.svg)](https://hub.docker.com/r/cv21/xhgui/) [![Docker stars](https://img.shields.io/docker/stars/cv21/xhgui.svg)](https://hub.docker.com/r/cv21/xhgui/)

Docker image allow to you use xhgui as service inside its own container. 
Just provide your data provider to container's mongo instance.

## Table Of Contents
- [Usage](#usage)
    - [Run as standalone container](#run-as-standalone-container)
    - [Run with docker-compose](#run-with-docker-compose)
- [Roadmap for 1.0 version](#roadmap-for-1.0-version)

## Usage

### Run as standalone container

You pull this image from [hub.docker.com](https://hub.docker.com) and run it with port mounting  

1. Run docker image
    ```
$ docker run -d -p 8081:80 cv21/xhgui
```

    There are:
    * flag `-d` mean that container runs in `detached` mode
    * flag `-p` mount local port `8081` with container port `80`

2. Open http://127.0.0.1:8081

### Run with docker-compose

Configure set of services and run this image as its part.

All that you needs it's just:

* Install and configure **Xhprof** or **Tideways** extension
* Install and configure xhgui on php worker
* Configure docker-compose.yml
* Build and run set of services

1. Install and configure **Xhprof** or **Tideways** extension

    Additionally, you need to install `mcrypt` and `pkg-config`.
    Edit Dockerfile for your php worker with lines described below.

    ```        
    # install mcrypt for xhgui
    RUN apt-get install -y mcrypt php7.1-mcrypt
    
    # install pkg-config for pecl
    RUN apt-get install -y pkg-config
    
    # install Tideways profiler extension
    RUN git clone https://github.com/tideways/php-profiler-extension.git
    RUN cd php-profiler-extension && phpize && ./configure && make && make install
    ```

2. Install and configure xhgui on php worker

    Edit Dockerfile for your php worker like php-fpm according described below.
    You need to have installed composer inside your php worker container.

    ```
    # install mongodb extension for xhgui
    RUN pecl install mongodb
    
    # install xhgui
    RUN git clone https://github.com/perftools/xhgui.git /xhgui
    
    # configure xhgui symply adding config file to container
    ADD ./xhgui.config.php /xhgui/config/config.php
    
    # init container by running installation of composer for xhgui and staring fpm 
    CMD composer install -d /xhgui && fpm-start
    ```

3. Configure your [docker-compose.yml](https://docs.docker.com/compose/compose-file/)
    
    ```
    version: "2"
    services:
        web: ...                 # web server like nginx
        backend:                 # php worker like php-fpm wuth xhprof or Tideways extension
            ...
            links: [db, xhgui]   # links backend service with db and xhgui services
        db: ...                  # app database service
        xhgui:                   # xhgui image described as service
            image: cv21/xhgui
            ports: 
                - 8081:80        # mount xhgui on port 8081
    ```
    
4. Build
    ```
$ docker-compose build .
```

4. Run
    ```
$ docker-compose up -d
```

5. Execute any php script on php worker

5. Open xhgui by link http://127.0.0.1:8081 and see results

## Roadmap for 1.0 version

- [x] Allow to use xhgui codebase by in-folder code
- [x] Allow to use configs
- [ ] Update docs
