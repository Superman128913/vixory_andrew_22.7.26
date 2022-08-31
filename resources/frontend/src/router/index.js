import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store.js'

//Account pages
import Account from '../views/account/Account'
import Connections from '../views/account/pages/connections/Connections'
import Articles from '../views/account/pages/articles/Articles'
import SingleArticle from '../views/account/pages/articles/SingleArticle'
import Videos from '../views/account/pages/videos/Videos'
import SingleVideo from '../views/account/pages/videos/SingleVideo'
import Profile from '../views/account/pages/profile/Profile'
import SportsData from '../views/account/pages/sports-data/SportsData'
import Subscription from '../views/account/pages/subscriptions/Subscription'
import SavedSearches from '../views/account/pages/saved-searches/SavedSearches'

//General backend pages
import Login from '../views/Login'
import RegisterCoach from '../views/register/RegisterCoach'
import Register from '../views/register/Register'
import ForgotPassword from '../views/password/ForgotPassword'
import ResetPassword from '../views/password/ResetPassword'
import VerifyEmail from '../views/VerifyEmail'
import PendingApproval from '../views/PendingApproval'
import Deactivated from '../views/deactivated/Deactivated'
import TermsOfUse from '../views/TermsOfUse'
import PrivacyPolicy from '../views/PrivacyPolicy'
import FulfillmentPolicy from '../views/FulfillmentPolicy'
import FAQ from '../views/Faq'
import NotFoundComponent from '../views/NotFoundComponent'
import MaintenanceMode from '../views/MaintenanceMode'
import NextSteps from '../views/register/NextSteps'

//Marketing and front end pages
import Home from '../views/Home'
import Search from '../views/search/Search'
import About from '../views/About'
import Pricing from '../views/pricing/Pricing'
import ProfilePage from '../views/social/ProfilePage'
import ControllingYourInformation from '../views/ControllingYourInformation'
import BlogArchive from '../views/blog/Archive'
import BlogSingle from '../views/blog/Single'

Vue.use(VueRouter)

  const routes = [
    {
		path: '/',
		name: 'home',
		component: Home
	},
	{
		path: '/search',
		name: 'search',
		component: Search,
	},
	{
		path: '/search/:id',
		name: 'saved-search-view',
		component: Search,
	},
	{
		path: '/pending-approval',
		name: 'pending-approval',
		component: PendingApproval,
	},
	{
		path: '/deactivated',
		name: 'deactivated',
		component: Deactivated,
	},
	{
		path: '/next-steps',
		name: 'next-steps',
		component: NextSteps
	},
	{
		path: '/account',
		component: Account,
		children: [
			{
				name: 'profile',
				path: '/',
				component: Profile
			},
			{
				name: 'connections',
				path: 'connections',
				component: Connections
			},
			{
				name: 'saved-searches',
				path: 'saved-searches',
				component: SavedSearches
			},
			{
				name: 'articles',
				path: 'articles',
				component: Articles
			},
			{
				name: 'new-article',
				path: 'articles/new',
				component: SingleArticle
			},
			{
				name: 'single-article',
				path: 'articles/:id',
				component: SingleArticle
			},
			{
				name: 'sports-data',
				path: 'sports-data',
				component: SportsData
			},
			{
				name: 'videos',
				path: 'videos',
				component: Videos
			},
			{
				name: 'new-video',
				path: 'videos/new',
				component: SingleVideo
			},
			{
				name: 'single-video',
				path: 'videos/:id',
				component: SingleVideo
			},
			{
				name: 'subscription',
				path: 'subscription',
				component: Subscription
			},
		]
	},
	{
		path: '/email/verify',
		name: 'verify-email',
		component: VerifyEmail
	},
	{
		path: '/entry',
		name: 'login',
		component: Login,
		beforeEnter: loggedOut
	},
	{
		path: '/blog',
		name: 'blog',
		component: BlogArchive,
	},
	{
		path: '/blog/page/:pagination',
		name: 'blog',
		component: BlogArchive,
	},
	{
		path: '/blog/:title',
		name: 'blog-single',
		component: BlogSingle,
	},
	{
		path: '/terms-of-use',
		name: 'terms-of-use',
		component: TermsOfUse,
	},
	{
		path: '/privacy-policy',
		name: 'privacy-policy',
		component: PrivacyPolicy,
	},
	{
		path: '/fulfillment-policy',
		name: 'fulfillment-policy',
		component: FulfillmentPolicy,
	},
	{
		path: '/forgot-password',
		name: 'forgot-password',
		component: ForgotPassword,
	},
	{
		path: '/faq',
		name: 'faq',
		component: FAQ,
	},
	{
		path: '/reset-password',
		name: 'reset-password',
		component: ResetPassword
	},
	{
		path: '/signup/coach',
		name: 'coach-register',
		component: RegisterCoach,
	},
	{
		path: '/signup/:planId',
		name: 'register',
		component: Register,
	},
	{
		path: '/about',
		name: 'about',
		component: About
	},
	{
		path: '/registration',
		name: 'register-plans',
		component: Pricing,
	},
	{
		path: '/your-info',
		name: 'your-info',
		component: ControllingYourInformation,
	},
	{
		path: '/profile/:id',
		name: 'social-profile',
		component: ProfilePage
	},
	{
		path: '/maintenance-mode',
		name: 'maintenance-mode',
		component: MaintenanceMode,
		meta: {
			layout:"canvas"
		}
	},
	{ 
		path: '*', 
		component: NotFoundComponent,
		meta: {
			layout:"canvas"
		}
	}
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

/**
 * On every route which is specified, confirm user is not logged in.
 * 
 * Note: Axios interceptors will redirect to the login page if any api requests return 401. This function is
 * handeling the opposite, where a user shouldn't be logged in to view e.g. Register/Login.
 */
function loggedOut(to, from, next) {
	if(! store.getters.getAuthenticated) {
		next();
	}
	else {
		//Redirect to profile page.
		next({name:"profile"});
	}
}

//Scroll to top of page on every page view
router.beforeEach((to, from, next) => {
	//If path is the same than it's probably just a change in the hash which we can ignore.
	if(to.path != from.path) {
		window.scrollTo(0,0);
		next();
	}
	else {
		next();
	}
});

//On every route check to make sure that if the user is logged in that vuex has stored the user.
router.beforeEach((to, from, next) => {
    store.dispatch('checkUser');
    next();
});

//Load meta tags
router.beforeEach((to, from, next) => {
	// This goes through the matched routes from last to first, finding the closest route with a title.
	// eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
	const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);
  
	// Find the nearest route element with meta tags.
	const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
	const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
  
	// If a route with a title was found, set the document (page) title to that value.
	if(nearestWithTitle) document.title = nearestWithTitle.meta.title;
  
	// Remove any stale meta tags from the document using the key attribute we set below.
	Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));
  
	// Skip rendering meta tags if there are none.
	if(!nearestWithMeta) return next();
  
	// Turn the meta tag definitions into actual elements in the head.
	nearestWithMeta.meta.metaTags.map(tagDef => {
	  const tag = document.createElement('meta');
  
	  Object.keys(tagDef).forEach(key => {
		tag.setAttribute(key, tagDef[key]);
	  });
  
	  // We use this to track which meta tags we create, so we don't interfere with other ones.
	  tag.setAttribute('data-vue-router-controlled', '');
  
	  return tag;
	})
	// Add the meta tags to the document head.
	.forEach(tag => document.head.appendChild(tag));
  
	next();
});

export default router
