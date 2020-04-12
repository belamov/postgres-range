const isDev = process.env.NODE_ENV !== 'production';
const base = isDev ? '/' : '/postgres-range/';

module.exports = {
    base,
    title: 'postgres-range',
    description: 'Support of PostgreSQL\'s range types in your Laravel app',
    themeConfig: {
        nav: [
            { text: 'Home', link: '/' },
            { text: 'Documentation', link: '/documentation/getting-started' },
            { text: 'Source', link: 'https://github.com/belamov/postgres-range/' }
        ],
        sidebar: {
            '/documentation/': [
                {
                    title: 'Documentation',
                    collapsable: false,
                    children: [
                        'getting-started',
                        'available-types',
                        'query-builder',
                        'indexes-and-constraints',
                    ]
                },
            ]
        }

    }
};