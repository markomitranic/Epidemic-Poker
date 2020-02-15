FROM nginx:1.17 AS base

COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/default.conf /etc/nginx/conf.d/default.conf

FROM base AS prod
COPY --from=epidemicpoker_frontend /app/epidemicpoker/public /var/www/html/public
COPY --from=epidemicpoker_frontend /app/epidemicpoker/build /var/www/html/build
