FROM node:13-stretch-slim AS base
USER root
WORKDIR /app/epidemicpoker/

FROM base AS prod
ENV NODE_ENV=production
COPY ./src/ /app/epidemicpoker/
RUN yarn install && yarn run production

FROM prod AS dev
ENV NODE_ENV=development
COPY entrypoint_dev.sh /app/entrypoint.sh
ENTRYPOINT ["/app/entrypoint.sh"]