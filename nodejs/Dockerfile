FROM node:9.11.1-alpine

LABEL maintainer="Carlos Thurber B."

ENV NODE_ENV production

RUN mkdir -p /usr/app
COPY package.json /usr/app/

WORKDIR /usr/app

RUN npm install

COPY src /usr/app/src

EXPOSE 3000

CMD npm start
