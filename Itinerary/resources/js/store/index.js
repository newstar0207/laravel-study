export const index = {
    state: () => ({
        test: 'h2h',
        currentRoom : {},
        openRoom : false,
        roomList: [],
        user : {},
        chats : [],
    }),
    mutations: {
        openChatRoom(state, room) {
            console.log('setOpenChatRoom...')
            state.currentRoom = room
            state.openRoom = true
        },
        setRoomList(state, List) {
            state.roomList = List
            console.log(List, 'setRoomList...')
        },
        setUser(state, user) {
            state.user = user
        },
        setChat(state, chats) {
            state.chats = chats
        },
        getUser(state) {
            return state.user
        }

    },
    getters: {
        getRoomList(state) {
            console.log(state.roomList, 'getRoomList...')
            return state.roomList;
        },
        getCurrentRoom(state) {
            console.log('getCurrentRoom...')
            return state.currentRoom;
        },
        getOpenRoom(state) {
            return state.openRoom;
        }
    },
    actions: {

    }

}
